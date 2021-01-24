CREATE TABLE safeapp.user (
	id			VARCHAR(32) NOT NULL UNIQUE
,	email		VARCHAR(200) NOT NULL UNIQUE
,	password	VARCHAR(1024) NOT NULL
,	clock		DATETIME NOT NULL
,	trys		INT NOT NULL DEFAULT 0
,	ip			VARCHAR(39) DEFAULT NULL
,	status		enum('activate', 'inactivate') NOT NULL
,	token		VARCHAR(32) DEFAULT NULL UNIQUE
,	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE safeapp.messange (
	id			VARCHAR(32) NOT NULL UNIQUE
,	userId		VARCHAR(32) NOT NULL
,	content		VARCHAR(1024) NOT NULL
,	public		enum('yes', 'no') NOT NULL DEFAULT 'no'
,	encrypted	enum('yes', 'no') NOT NULL DEFAULT 'no'
,	PRIMARY KEY (id)
,	FOREIGN KEY (userId) REFERENCES safeapp.user(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;