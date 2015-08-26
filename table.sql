CREATE TABLE feeds (
    id integer,
    module text,
    cat text,
    filter text,
    created timestamp DEFAULT now(),
    PRIMARY KEY(id, module, filter)
);