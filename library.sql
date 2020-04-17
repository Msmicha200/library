CREATE TABLE accounts(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Login VARCHAR(255) NOT NULL UNIQUE,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(512) NOT NULL,
    Token VARCHAR(512)
) CHARACTER SET utf8;
CREATE TABLE authors(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(512) NOT NULL
) CHARACTER SET utf8;
CREATE TABLE genres(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(512) NOT NULL
) CHARACTER SET utf8;
CREATE TABLE books(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Title VARCHAR(60) NOT NULL,
    Description TEXT(500) NOT NULL,
    Image TEXT(160000) NOT NULL,
    Audio VARCHAR(1024),
    Pdf VARCHAR(1024) NOT NULL,
    AuthorId INT NOT NULL,
    GenreId INT NOT NULL,
    IsArchived TINYINT NOT NULL DEFAULT 0,
    FOREIGN KEY(AuthorId) REFERENCES authors(Id),
    FOREIGN KEY(GenreId) REFERENCES genres(Id)
) CHARACTER SET utf8;
CREATE TABLE collection(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    BookId INT NOT NULL,
    UserId INT NOT NULL,
    FOREIGN KEY(BookId) REFERENCES books(Id),
    FOREIGN KEY(UserId) REFERENCES accounts(Id)
) CHARACTER SET utf8;
CREATE TABLE comments(
    Id INT PRIMARY KEY AUTO_INCREMENT,
    Comment TEXT(500) NOT NULL,
    BookId INT NOT NULL,
    UserId INT NOT NULL,
    Date TIMESTAMP NOT NULL,
    FOREIGN KEY(BookId) REFERENCES books(Id),
    FOREIGN KEY(UserId) REFERENCES accounts(Id)
) CHARACTER SET utf8;
DELIMITER
    //
CREATE
PROCEDURE sort(
    IN AuthorId INT,
    IN GenreId INT
)
BEGIN
        IF AuthorId > 0 AND GenreId > 0 THEN
    SELECT
        b.Id,
        b.Title,
        b.Description,
        a.Name,
        g.Title AS GenreTitle,
        b.Image,
        b.Audio,
        b.Pdf,
        b.IsArchived
    FROM
        books AS b,
        authors AS a,
        genres AS g
    WHERE
        b.AuthorId = a.Id AND b.GenreId = g.Id AND b.AuthorId = AuthorId AND b.GenreId = GenreId AND b.IsArchived < 1 ; ELSEIF AuthorId > 0 THEN
    SELECT
        b.Id,
        b.Title,
        b.Description,
        a.Name,
        g.Title AS GenreTitle,
        b.Image,
        b.Audio,
        b.Pdf,
        b.IsArchived
    FROM
        books AS b,
        authors AS a,
        genres AS g
    WHERE
        b.AuthorId = a.Id AND b.GenreId = g.Id AND b.AuthorId = AuthorId AND b.IsArchived < 1 ; ELSEIF GenreId > 0 THEN
    SELECT
        b.Id,
        b.Title,
        b.Description,
        a.Name,
        g.Title AS GenreTitle,
        b.Image,
        b.Audio,
        b.Pdf,
        b.IsArchived
    FROM
        books AS b,
        authors AS a,
        genres AS g
    WHERE
        b.AuthorId = a.Id AND b.GenreId = g.Id AND b.GenreId = GenreId AND b.IsArchived < 1 ;
    END IF ;
END //

ALTER TABLE collection ADD UNIQUE unique_index(BookId, UserId);