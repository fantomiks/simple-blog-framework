<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    public const PDO_FETCH_MULTI = 'multi';
    public const PDO_FETCH_SINGLE = 'single';
    public const PDO_FETCH_VALUE = 'value';

    private PDO $conn;
    private array $executeParams;
    private string $fetchType;
    private string $sql;
    private string $tableName;
    private array $where;
    private array $join;
    private array $orderBy;
    private ?int $limit = 10;
    private ?int $offset = 0;

    /**
     * Class constructor.
     *
     * Setup connection to database and initialize.
     *
     * @param array $database Database credentials.
     * @return void
     */
    public function __construct( $database ) {
        try { // open pdo connection to the database
            $this->conn = new PDO( 'mysql:host=' . $database['hostname'] . ';dbname=' . $database['database'], $database['username'], $database['password'] );
            $this->conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            $this->initialize();
        } catch ( PDOException $e ) { // connection to database failed, die with the error message
            throw $e;
        }
    }

    /**
     * Initialize class variables.
     *
     * Set class variables to defaults so they are ready for a new query to be setup and ran.
     *
     * @return void
     */
    private function initialize() {
        $this->sql = '';
        $this->tableName = '';
        $this->executeParams = [];
        $this->join = [];
        $this->where = [];
        $this->orderBy = [];
        $this->fetchType = '';
        $this->limit = 10;
        $this->offset = 0;
    }

    /**
     * Build the join part of sql.
     *
     * Loop over and add the join array and add them to the sql query.
     *
     * @return void
     */
    private function buildJoin() {
        if ( $this->join ) {
            foreach ( $this->join as $join ) { // loop over joins array
                // add join to sql statement
                $this->sql .= ' ' . strtoupper( $join['type'] ) . ' JOIN ' . $join['table'] . ' ON ( ' . $join['on'] . ' )';
            }
        }
    }

    /**
     * Build the where part of sql.
     *
     * Loop over and add the where column/values to the sql query.
     *
     * @return void
     */
    private function buildWhere() {
        if ( $this->where ) { // we have where clauses to add
            $this->sql .= ' WHERE';

            foreach ( $this->where as $where ) { // loop over where array
                $columnVariableName = ':' . str_replace( '.', '', $where['column'] );
                $this->sql .= ' ' . $where['type'] . ' ' . $where['column'] . ' = ' . $columnVariableName;
                $this->executeParams[$columnVariableName] = $where['value'];
            }
        }
    }

    /**
     * Build the order by part of sql.
     *
     * Loop over and add the order by columns and directions to the sql query.
     *
     * @return void
     */
    private function buildOrderBy() {
        if ( !empty($this->orderBy) ) {
            $orderBy = [];

            foreach ( $this->orderBy as $order ) {
                $orderBy[] = $order['column'] . ' ' . $order['direction'];
            }

            $this->sql .= ' ORDER BY ' . implode( ', ', $orderBy );
        }
    }

    private function buildLimitAndOffset() {
        $this->sql .= " LIMIT {$this->offset}, {$this->limit} ";
    }

    /**
     * Run a query.
     *
     * Run the query on the database and return the result.
     *
     * @return array|int $result Data from the database query.
     */
    private function runQuery(): array|int
    {
        $pdo = $this->conn->prepare( $this->sql );

        $pdo->setFetchMode( PDO::FETCH_ASSOC );

        $pdo->execute( $this->executeParams );

        $result = match ($this->fetchType) {
            self::PDO_FETCH_SINGLE => $pdo->fetch(),
            self::PDO_FETCH_MULTI => $pdo->fetchAll(),
            self::PDO_FETCH_VALUE => $pdo->fetchColumn(),
            default => $this->conn->lastInsertId(),
        };

        $this->initialize();

        return $result;
    }

    /**
     * Set fetch.
     *
     * Set the fetch type the pdo result with use.
     *
     * @param string $fetchType Accepts 'multi', or 'single'.
     * @return void
     */
    public function fetch( string $fetchType ): self
    {
        $this->fetchType = $fetchType;

        return $this;
    }

    /**
     * Set join.
     *
     * Set a join for use when running the query.
     *
     * @param string $type        Type of join (left, right, etc).
     * @param string $tableString Name of the table for joining.
     * @param string $on          ON string for the join.
     * @return void
     */
    public function join( string $type, string $tableString, string $onString ): self
    {
        $this->join[] = [
            'type' => $type,
            'table' => $tableString,
            'on' => $onString,
        ];

        return $this;
    }

    /**
     * Set order by.
     *
     * Set order by for use when running the query.
     *
     * @param string $column    Name of the column in for order.
     * @param string $direction Value for the direction of the column for order.
     * @return void
     */
    public function orderBy( string $column, string $direction ): self
    {
        $this->orderBy[] = array(
            'column' => $column,
            'direction' => $direction
        );

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Run custom query.
     *
     * Run a custom query on the database.
     *
     * @param string $sql    String of the sql to run. This should contain variables in place of the values.
     * @param array  $params Array of the params. The keys should be the variables in the $sql. The values should be the actual values.
     * @return array
     */
    public function runCustomQuery( string $sql, array $params = [] ): array
    {
        $this->sql = $sql;
        $this->executeParams = $params;

        return $this->runQuery();
    }

    /**
     * Run delete query.
     *
     * Run a delete query on the database.
     *
     * @param array $deleteData Array keys must be the name of the columns in the database table.
     * @return array
     */
    public function runDeleteQuery(): array
    {
        $this->sql = "DELETE FROM {$this->tableName}";
        $this->buildWhere();

        return $this->runQuery();
    }

    /**
     * Run insert query.
     *
     * Run an insert query on the database.
     *
     * @param array $insertData Array keys must be the name of the columns in the database table.
     * @return array ID of the row inserted.
     */
    public function runInsertQuery( array $insertData ): array
    {
        $this->sql = '
				INSERT INTO ' .
            $this->tableName . '(' .
            implode( ',', array_keys( $insertData ) ) .
            ') 
				VALUES (' .
            ':' . implode( ',:', array_keys( $insertData ) ) .
            ')';

        foreach ( $insertData as $column => $value ) {
            $this->executeParams[':' . $column] = $value;
        }

        return $this->runQuery();
    }

    /**
     * Run select query.
     *
     * Run a select query on the database.
     *
     * @param string $select Comma separated column names to select.
     * @return array Data returned from the database.
     */
    public function runSelectQuery(string $select = '*' ): array
    {
        $this->sql = "SELECT {$select} FROM {$this->tableName}";

        $this->buildJoin();
        $this->buildWhere();
        $this->buildOrderBy();
        $this->buildLimitAndOffset();

        return $this->runQuery();
    }

    /**
     * Run select query.
     *
     * Run a select query on the database.
     *
     * @return int Data returned from the database.
     */
    public function runCountQuery()
    {
        $this->sql = "SELECT COUNT(*) FROM {$this->tableName}";

        $this->buildJoin();
        $this->buildWhere();
        $this->buildOrderBy();

        return $this->runQuery();
    }

    /**
     * Run update query.
     *
     * Run an update query on the database.
     *
     * @param array $updateData Array keys must be the name of the columns in the database table.
     * @return void
     */
    public function runUpdateQuery( $updateData ) {
        $setSql = '';

        $count = 1;

        foreach ( $updateData as $column => $value ) {
            $setSql .= $column . ' = :' . $column . ( $count != count( $updateData ) ? ', ' : '' );
            $this->executeParams[':' . $column] = $value;
            $count++;
        }

        $this->sql = "UPDATE {$this->tableName} SET {$setSql}";
        $this->buildWhere();

        $this->runQuery();
    }

    /**
     * Set tablename.
     *
     * Set the tableName class var.
     *
     * @param string $tableName Database table to use with the query.
     * @return void
     */
    public function table( string $tableName ): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * Set where.
     *
     * Set a where clause for use when running the query.
     *
     * @param string $column Name of the column in the where clause.
     * @param string $value  Value for the column in the where clause.
     * @param string $type   Type of where clause. Accepts 'AND', or 'OR'. Default empty;
     * @return void
     */
    public function where( string $column, mixed $value, string $type = '' ): self
    {
        $this->where[] = [
            'column' => $column,
            'value' => $value,
            'type' => $type,
        ];

        return $this;
    }

}
