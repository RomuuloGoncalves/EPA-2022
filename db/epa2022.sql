DROP DATABASE IF EXISTS EPA2022;
CREATE DATABASE EPA2022;
USE EPA2022;


DROP TABLE IF EXISTS GRUPOS;
CREATE TABLE GRUPOS (
    ID_GRUPO INT AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(50) NOT NULL
);

INSERT INTO GRUPOS VALUES(0, 'Quarto'), (0, 'Cozinha'), (0, 'Varanda'), (0, 'Sala');

DROP TABLE IF EXISTS LAMPADAS;
CREATE TABLE LAMPADAS (
    ID_LAMPADA INT AUTO_INCREMENT PRIMARY KEY,
    NOME VARCHAR(50) DEFAULT NULL,
    PORTA INT NOT NULL,
    ESTADO BIT(1) DEFAULT 0
);

INSERT INTO LAMPADAS VALUES(0, 'Quarto-1', 21, 0), (0, 'Quarto-2', 19, 1), (0, 'Cozinha-1', 4, 1), (0, 'Varanda-1', 23, 0), (0, 'Sala-1', 2, 0);

DROP TABLE IF EXISTS ROTINAS;
CREATE TABLE ROTINAS (
    ID_ROTINA INT AUTO_INCREMENT PRIMARY KEY,
    H_INICIO INT DEFAULT NULL,
    H_FIM INT DEFAULT NULL,
    M_INICIO INT DEFAULT NULL,
    M_FIM INT DEFAULT NULL
);

DROP TABLE IF EXISTS LAMPADAS_ROTINA;
CREATE TABLE LAMPADAS_ROTINA (
    ID_ROTINA INT NOT NULL,
    ID_LAMPADA INT NOT NULL,
    KEY LAMPADAS_ROTINAS_FKID1 (ID_ROTINA),
    KEY LAMPADAS_ROTINAS_FKID2 (ID_LAMPADA), 
    CONSTRAINT LAMPADAS_ROTINAS_IBFK1 FOREIGN KEY (ID_ROTINA) REFERENCES  ROTINAS (ID_ROTINA),
    CONSTRAINT LAMPADAS_ROTINAS_IBFK2 FOREIGN KEY (ID_LAMPADA) REFERENCES LAMPADAS (ID_LAMPADA)
);

DROP TABLE IF EXISTS LAMPADAS_GRUPO;
CREATE TABLE LAMPADAS_GRUPO (
    ID_GRUPO INT NOT NULL,
    ID_LAMPADA INT NOT NULL,
    KEY LAMPADAS_GRUPO_FKID1 (ID_GRUPO),
    KEY LAMPADAS_GRUPO_FKID2 (ID_LAMPADA), 
    CONSTRAINT LAMPADAS_GRUPO_IBFK1 FOREIGN KEY (ID_GRUPO) REFERENCES GRUPOS (ID_GRUPO),
    CONSTRAINT LAMPADAS_GRUPO_IBFK2 FOREIGN KEY (ID_LAMPADA) REFERENCES LAMPADAS (ID_LAMPADA)
);

INSERT INTO LAMPADAS_GRUPO VALUES(1, 1), (1,2), (2,3), (3,4), (4,5);