CREATE TABLE Medecin(
       id_medecin int NOT NULL AUTO_INCREMENT,
       civilite VARCHAR(20) NOT NULL,
       nom VARCHAR(100) NOT NULL,
       prenom VARCHAR(100) NOT NULL,
       PRIMARY KEY(id_medecin)
);

CREATE TABLE Patient (
	id_patient integer NOT NULL AUTO_INCREMENT,
	id_medecin integer,
	civilite varchar(20) NOT NULL,
	nom varchar(100) NOT NULL,
	prenom varchar(100) NOT NULL,
	adresse varchar(255) NOT NULL,
	date_naissance date NOT NULL,
	num_secu char(15) NOT NULL,
	PRIMARY KEY (id_patient),
	FOREIGN KEY(id_medecin) REFERENCES Medecin(id_medecin)
);

CREATE TABLE Consultation (
       id_medecin int NOT NULL,
       id_patient int NOT NULL,
       date_debut DATETIME NOT NULL,
       date_fin DATETIME NOT NULL,
       FOREIGN KEY (id_medecin) REFERENCES Medecin(id_medecin),
       FOREIGN KEY (id_patient) REFERENCES Patient(id_patient),
       PRIMARY KEY (id_medecin, id_patient, date_debut)
);

