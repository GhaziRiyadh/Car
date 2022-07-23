create table causes
(
    id             bigint unsigned auto_increment
        primary key,
    cause          text            not null,
    causeable_type varchar(255)    not null,
    causeable_id   bigint unsigned not null,
    created_at     timestamp       null,
    updated_at     timestamp       null
)
    collate = utf8mb4_unicode_ci;

create index causes_causeable_type_causeable_id_index
    on causes (causeable_type, causeable_id);

create table classes
(
    id         bigint unsigned auto_increment
        primary key,
    name       char(50)        not null,
    status     bigint unsigned not null,
    course_id  bigint unsigned not null,
    start_time time            not null,
    end_time   time            not null,
    date       date            not null,
    created_at timestamp       null,
    updated_at timestamp       null
)
    collate = utf8mb4_unicode_ci;

create table classes_states
(
    id         bigint unsigned auto_increment
        primary key,
    status     char(20)  not null,
    created_at timestamp null,
    updated_at timestamp null
)
    collate = utf8mb4_unicode_ci;

create table course_students
(
    id         bigint unsigned auto_increment
        primary key,
    student_id bigint unsigned not null,
    course_id  bigint unsigned not null,
    created_at timestamp       null,
    updated_at timestamp       null
)
    collate = utf8mb4_unicode_ci;

create table course_teachers
(
    id         bigint unsigned auto_increment
        primary key,
    teacher_id bigint unsigned not null,
    course_id  bigint unsigned not null,
    created_at timestamp       null,
    updated_at timestamp       null
)
    collate = utf8mb4_unicode_ci;

create table course_types
(
    id         bigint unsigned auto_increment
        primary key,
    type       char(20)  not null,
    created_at timestamp null,
    updated_at timestamp null
)
    collate = utf8mb4_unicode_ci;

create table courses
(
    id         bigint unsigned auto_increment
        primary key,
    name       char(50)        not null,
    type       bigint unsigned not null,
    subject_id bigint unsigned not null,
    start_date date            not null,
    end_date   date            not null,
    created_at timestamp       null,
    updated_at timestamp       null
)
    collate = utf8mb4_unicode_ci;

create table failed_jobs
(
    id         bigint unsigned auto_increment
        primary key,
    uuid       varchar(255)                        not null,
    connection text                                not null,
    queue      text                                not null,
    payload    longtext                            not null,
    exception  longtext                            not null,
    failed_at  timestamp default CURRENT_TIMESTAMP not null,
    constraint failed_jobs_uuid_unique
        unique (uuid)
)
    collate = utf8mb4_unicode_ci;

create table home_works
(
    id         bigint unsigned auto_increment
        primary key,
    name       char(50)        not null,
    class_id   bigint unsigned not null,
    created_at timestamp       null,
    updated_at timestamp       null
)
    collate = utf8mb4_unicode_ci;

create table migrations
(
    id        int unsigned auto_increment
        primary key,
    migration varchar(255) not null,
    batch     int          not null
)
    collate = utf8mb4_unicode_ci;

create table password_resets
(
    email      varchar(255) not null,
    token      varchar(255) not null,
    created_at timestamp    null
)
    collate = utf8mb4_unicode_ci;

create index password_resets_email_index
    on password_resets (email);

create table permissions
(
    id           bigint unsigned auto_increment
        primary key,
    name         varchar(255) not null,
    display_name varchar(255) null,
    description  varchar(255) null,
    created_at   timestamp    null,
    updated_at   timestamp    null,
    constraint permissions_name_unique
        unique (name)
)
    collate = utf8mb4_unicode_ci;

create table permission_user
(
    permission_id bigint unsigned not null,
    user_id       bigint unsigned not null,
    user_type     varchar(255)    not null,
    primary key (user_id, permission_id, user_type),
    constraint permission_user_permission_id_foreign
        foreign key (permission_id) references permissions (id)
            on update cascade on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table personal_access_tokens
(
    id             bigint unsigned auto_increment
        primary key,
    tokenable_type varchar(255)    not null,
    tokenable_id   bigint unsigned not null,
    name           varchar(255)    not null,
    token          varchar(64)     not null,
    abilities      text            null,
    last_used_at   timestamp       null,
    created_at     timestamp       null,
    updated_at     timestamp       null,
    constraint personal_access_tokens_token_unique
        unique (token)
)
    collate = utf8mb4_unicode_ci;

create index personal_access_tokens_tokenable_type_tokenable_id_index
    on personal_access_tokens (tokenable_type, tokenable_id);

create table roles
(
    id           bigint unsigned auto_increment
        primary key,
    name         varchar(255) not null,
    display_name varchar(255) null,
    description  varchar(255) null,
    created_at   timestamp    null,
    updated_at   timestamp    null,
    constraint roles_name_unique
        unique (name)
)
    collate = utf8mb4_unicode_ci;

create table permission_role
(
    permission_id bigint unsigned not null,
    role_id       bigint unsigned not null,
    primary key (permission_id, role_id),
    constraint permission_role_permission_id_foreign
        foreign key (permission_id) references permissions (id)
            on update cascade on delete cascade,
    constraint permission_role_role_id_foreign
        foreign key (role_id) references roles (id)
            on update cascade on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table role_user
(
    role_id   bigint unsigned not null,
    user_id   bigint unsigned not null,
    user_type varchar(255)    not null,
    primary key (user_id, role_id, user_type),
    constraint role_user_role_id_foreign
        foreign key (role_id) references roles (id)
            on update cascade on delete cascade
)
    collate = utf8mb4_unicode_ci;

create table sessions
(
    id            varchar(255)    not null
        primary key,
    user_id       bigint unsigned null,
    ip_address    varchar(45)     null,
    user_agent    text            null,
    payload       longtext        not null,
    last_activity int             not null
)
    collate = utf8mb4_unicode_ci;

create index sessions_last_activity_index
    on sessions (last_activity);

create index sessions_user_id_index
    on sessions (user_id);

create table subjects
(
    id         bigint unsigned auto_increment
        primary key,
    name       char(50)  not null,
    created_at timestamp null,
    updated_at timestamp null
)
    collate = utf8mb4_unicode_ci;

create table subjects_types
(
    id         bigint unsigned auto_increment
        primary key,
    type       char(20)  not null,
    created_at timestamp null,
    updated_at timestamp null
)
    collate = utf8mb4_unicode_ci;

create table user_types
(
    id         bigint unsigned auto_increment
        primary key,
    type       char(20)  not null,
    created_at timestamp null,
    updated_at timestamp null
)
    collate = utf8mb4_unicode_ci;

create table users
(
    id                        bigint unsigned auto_increment
        primary key,
    name                      varchar(255)    not null,
    email                     varchar(255)    null,
    email_verified_at         timestamp       null,
    password                  varchar(255)    not null,
    two_factor_secret         text            null,
    two_factor_recovery_codes text            null,
    two_factor_confirmed_at   timestamp       null,
    acadimyId                 bigint          null,
    remember_token            varchar(100)    null,
    current_team_id           bigint unsigned null,
    profile_photo_path        varchar(2048)   null,
    created_at                timestamp       null,
    updated_at                timestamp       null,
    constraint users_acadimyid_unique
        unique (acadimyId),
    constraint users_email_unique
        unique (email)
)
    collate = utf8mb4_unicode_ci;


