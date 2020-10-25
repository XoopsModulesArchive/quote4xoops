CREATE TABLE quote4xoops (
    id     INT(5) UNSIGNED  NOT NULL AUTO_INCREMENT,
    author VARCHAR(50)      NOT NULL DEFAULT '',
    quote  VARCHAR(255)     NOT NULL DEFAULT '',
    showed INT(10) UNSIGNED NOT NULL DEFAULT '0',
    PRIMARY KEY (id),
    KEY showed (showed)
)
    ENGINE = ISAM;

