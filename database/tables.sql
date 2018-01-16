CREATE TABLE comments
	( id			 INT NOT NULL AUTO_INCREMENT,
	  video_id		 VARCHAR(30) NOT NULL,
	  video_time	 TIME,
	  seconds		 BIGINT,
	  content		 TEXT,
	  created_at	 DATETIME,
	  likes			 INT,
	  username		 VARCHAR(32) NOT NULL,
	  PRIMARY KEY(id)
	) DEFAULT CHARSET=utf8;
CREATE TABLE users
	( id			INT NOT NULL AUTO_INCREMENT,
	  email			VARCHAR(128) NOT NULL,
	  username	    VARCHAR(32) NOT NULL,
	  password      VARCHAR(60),
	  firstname		VARCHAR(36),
	  lastname		VARCHAR(36),
	  gender		VARCHAR(6),
	  country		VARCHAR(128),
	  birthday		DATE,
	  likes			INT,
	  joined_at		DATETIME,
	  hash      	VARCHAR(60),
  	confirmed		BOOLEAN,
	  UNIQUE(email),
	  UNIQUE(username),
	  PRIMARY KEY(id)
	);
CREATE TABLE user_like
	( user_id		INT NOT NULL,
	  comment_id	INT NOT NULL,
	  PRIMARY KEY(user_id, comment_id)
	);
CREATE TABLE user_auth
	( user_id		INT NOT NULL,
	  username		VARCHAR(32) NOT NULL,
	  hash			VARCHAR(60) NOT NULL,
	  init_date		DATETIME NOT NULL,
	  expire_date 	DATETIME,
	  confirmed		BOOLEAN,
      limit_date 	DATETIME,
	  PRIMARY KEY(user_id, hash)
	);
CREATE TABLE feedback
	( id			INT NOT NULL AUTO_INCREMENT,
	  username		VARCHAR(32),
	  message		VARCHAR(210),
      created_at	DATETIME,
	  PRIMARY KEY(id)
	);
ALTER TABLE comments CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
