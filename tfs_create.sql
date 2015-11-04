CREATE TABLE player (
id INTEGER,
name VARCHAR (20),
apikey VARCHAR(8) NOT NULL,
str DOUBLE,
spd DOUBLE,
dex DOUBLE,
def DOUBLE,
mod_str INTEGER,
mod_def INTEGER,
mod_spd INTEGER,
mod_dex INTEGER,
total DOUBLE,
lastupdate DATE,
PRIMARY KEY (id, lastupdate)
);