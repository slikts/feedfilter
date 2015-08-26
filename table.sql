CREATE TABLE feeds (
    id integer,
    module text,
    filter text,
    created timestamp DEFAULT now(),
    PRIMARY KEY(id, module, filter)
);