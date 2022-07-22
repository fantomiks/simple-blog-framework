create table users
(
    id         int auto_increment
        primary key,
    name       varchar(255)                        null,
    email      varchar(500)                        null,
    created_at timestamp                           null,
    updated_at timestamp default CURRENT_TIMESTAMP null
);




create table articles
(
    id         int auto_increment
        primary key,
    slug       varchar(500)                        null,
    title      varchar(255)                        null,
    content    text                                null,
    author_id  int                                 null,
    image_url  varchar(1000)                       null,
    created_at timestamp                           null,
    updated_at timestamp default CURRENT_TIMESTAMP null,
    constraint articles_users_id_fk
        foreign key (author_id) references users (id)
            on update cascade on delete cascade
);




create table comments
(
    id         int auto_increment
        primary key,
    user_id    int                                 null,
    article_id int                                 null,
    content    text                                null,
    created_at timestamp                           null,
    updated_at timestamp default CURRENT_TIMESTAMP null,
    constraint comments_articles_id_fk
        foreign key (article_id) references articles (id)
            on update cascade on delete cascade,
    constraint comments_users_id_fk
        foreign key (user_id) references users (id)
            on update cascade on delete cascade
);

