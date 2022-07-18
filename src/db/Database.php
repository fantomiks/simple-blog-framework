<?php

namespace App\Db;

use PDO;

class Database
{
    public const PDO_FETCH_MULTI = 'multi';
    public const PDO_FETCH_SINGLE = 'single';
    public const PDO_FETCH_VALUE = 'value';

    private static ?Database $instance = null;
    private PDO $pdo;

    private array $executeParams = [];
    private string $fetchType;
    private string $sql;
    private string $tableName;
    private array $where = [];
    private array $join = [];
    private array $orderBy = [];
    private ?int $limit = 10;
    private ?int $offset = 0;

    protected function __construct(string $host, string $user, string $pass, string $dbname)
    {
        $opt = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname . ';charset=utf8';
        $this->pdo = new PDO($dsn, $user, $pass, $opt);
    }

    protected function __clone()
    {
    }

    public static function instance(string $host = '', string $user = '', string $pass = '', string $dbname = ''): ?Database
    {
        if (self::$instance === null) {
            self::$instance = new Database($host, $user, $pass, $dbname);
        }
        return self::$instance;
    }

    /**
     * Initialize class variables.
     *
     * Set class variables to defaults so they are ready for a new query to be setup and ran.
     *
     * @return void
     */
    private function initialize()
    {
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
     * Set tablename.
     *
     * Set the tableName class var.
     *
     * @param string $tableName Database table to use with the query.
     * @return void
     */
    public function table(string $tableName): self
    {
        $this->tableName = $tableName;
        return $this;
    }

    /**
     * Set fetch.
     *
     * Set the fetch type the pdo result with use.
     *
     * @param string $fetchType Accepts 'multi', or 'single'.
     * @return Database
     */
    public function fetch( string $fetchType ): self
    {
        $this->fetchType = $fetchType;

        return $this;
    }

    /**
     * Build the join part of sql.
     *
     * Loop over and add the join array and add them to the sql query.
     *
     * @return void
     */
    private function buildJoin()
    {
        if ($this->join) {
            foreach ($this->join as $join) {
                $this->sql .= ' ' . strtoupper($join['type']) . ' JOIN ' . $join['table'] . ' ON ( ' . $join['on'] . ' )';
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
    private function buildWhere()
    {
        if ($this->where) {
            $this->sql .= ' WHERE';

            foreach ($this->where as $where) {
                $columnVariableName = ':' . str_replace('.', '', $where['column']);
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
    private function buildOrderBy()
    {
        if (!empty($this->orderBy)) {
            $orderBy = [];

            foreach ($this->orderBy as $order) {
                $orderBy[] = $order['column'] . ' ' . $order['direction'];
            }

            $this->sql .= ' ORDER BY ' . implode(', ', $orderBy);
        }
    }

    private function buildLimitAndOffset()
    {
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
        $stmt = $this->pdo->prepare($this->sql);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $stmt->execute($this->executeParams);

        $result = match ($this->fetchType) {
            self::PDO_FETCH_SINGLE => $stmt->fetch(),
            self::PDO_FETCH_MULTI => $stmt->fetchAll(),
            self::PDO_FETCH_VALUE => $stmt->fetchColumn(),
            default => $this->pdo->lastInsertId(),
        };

        $this->initialize();

        return $result;
    }

    /**
     * Set join.
     *
     * Set a join for use when running the query.
     *
     * @param string $type Type of join (left, right, etc).
     * @param string $tableString Name of the table for joining.
     * @param string $onString
     * @return Database
     */
    public function join(string $type, string $tableString, string $onString): self
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
     * @param string $column Name of the column in for order.
     * @param string $direction Value for the direction of the column for order.
     * @return Database
     */
    public function orderBy(string $column, string $direction): self
    {
        $this->orderBy[] = [
            'column' => $column,
            'direction' => $direction
        ];

        return $this;
    }

    /**
     * Set where.
     *
     * Set a where clause for use when running the query.
     *
     * @param string $column Name of the column in the where clause.
     * @param string $value Value for the column in the where clause.
     * @param string $type Type of where clause. Accepts 'AND', or 'OR'. Default empty;
     * @return Database
     */
    public function where(string $column, mixed $value, string $type = ''): self
    {
        $this->where[] = [
            'column' => $column,
            'value' => $value,
            'type' => $type,
        ];

        return $this;
    }

    /**
     * @param int $limit
     * @return $this
     */
    public function limit(int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset(int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Run select query.
     *
     * Run a select query on the database.
     *
     * @param string $select Comma separated column names to select.
     * @return array Data returned from the database.
     */
    public function runSelectQuery(string $select = '*'): array
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
     * @return array|int Data returned from the database.
     */
    public function runCountQuery(): array|int
    {
        $this->sql = "SELECT COUNT(*) FROM {$this->tableName}";

        $this->buildJoin();
        $this->buildWhere();
        $this->buildOrderBy();

        return $this->runQuery();
    }
}
