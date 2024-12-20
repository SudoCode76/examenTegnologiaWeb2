CREATE DATABASE jugueteria;

USE jugueteria;

CREATE TABLE PERFIL (
    id_perfil INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL
);




CREATE TABLE USUARIO (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    usuario VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    id_perfil INT,
    FOREIGN KEY (id_perfil) REFERENCES PERFIL(id_perfil)
);

 SELECT * from usuarios JOIN roles ON usuarios.roles_idroles = roles.idroles WHERE usuarios.usuario = ? AND usuarios.password = ?;
 SELECT * FROM USUARIO JOIN PERFIL ON USUARIO.id_perfil = PERFIL.id_perfil WHERE USUSARIO.USUARIO = ? AND USUARIO.password =?;



CREATE TABLE DEPARTAMENTO (
    id_departamento INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL
);

CREATE TABLE EMPLEADO (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    apellido VARCHAR(45) NOT NULL,
    nombre VARCHAR(45) NOT NULL,
    telefono INT(11) NOT NULL,
    direcccion VARCHAR(45) NOT NULL,
    fecha_nacimiento DATE NOT NULL,
    observaciones VARCHAR(45) NOT NULL,
    sueldo INT(11) NOT NULL,
    id_departamento INT,
    FOREIGN KEY (id_departamento) REFERENCES DEPARTAMENTO(id_departamento)
)

CREATE TABLE JUGUETE (
    id_juguete INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT(11) NOT NULL
);




INSERT INTO PERFIL (nombre) VALUES
('Administrador'),
('Empleado');

INSERT INTO USUARIO (nombre, apellido, usuario, password, id_perfil) VALUES
('Miguel', 'Zenteno', 'miguel', '123', 1);


INSERT INTO USUARIO (nombre, apellido, usuario, password, id_perfil) VALUES
('Juan', 'Perez', 'jperez', 'password1', 1),
('Ana', 'Garcia', 'agarcia', 'password2', 2),
('Luis', 'Martinez', 'lmartinez', 'password3', 1),
('Maria', 'Lopez', 'mlopez', 'password4', 2),
('Carlos', 'Sanchez', 'csanchez', 'password5', 1),
('Elena', 'Fernandez', 'efernandez', 'password6', 2),
('David', 'Gomez', 'dgomez', 'password7', 1),
('Laura', 'Diaz', 'ldiaz', 'password8', 2),
('Miguel', 'Torres', 'mtorres', 'password9', 1),
('Sara', 'Ramirez', 'sramirez', 'password10', 2);

INSERT INTO DEPARTAMENTO (nombre) VALUES
('Ventas'),
('Almacén'),
('Compras'),
('Marketing'),
('Recursos Humanos'),
('Contabilidad'),
('IT'),
('Logística'),
('Producción'),
('Calidad');

INSERT INTO EMPLEADO (apellido, nombre, telefono, direcccion, fecha_nacimiento, observaciones, sueldo, id_departamento) VALUES
('Perez', 'Juan', 1234567890, 'Calle A, 123', '1985-05-15', 'Sin observaciones', 50000, 1),
('Garcia', 'Ana', 2345678901, 'Calle B, 234', '1990-08-22', 'Sin observaciones', 48000, 2),
('Martinez', 'Luis', 3456789012, 'Calle C, 345', '1987-03-10', 'Sin observaciones', 51000, 3),
('Lopez', 'Maria', 4567890123, 'Calle D, 456', '1992-11-30', 'Sin observaciones', 47000, 4),
('Sanchez', 'Carlos', 5678901234, 'Calle E, 567', '1988-07-05', 'Sin observaciones', 53000, 5),
('Fernandez', 'Elena', 6789012345, 'Calle F, 678', '1991-09-12', 'Sin observaciones', 49000, 6),
('Gomez', 'David', 7890123456, 'Calle G, 789', '1984-02-20', 'Sin observaciones', 55000, 7),
('Diaz', 'Laura', 8901234567, 'Calle H, 890', '1993-12-18', 'Sin observaciones', 46000, 8),
('Torres', 'Miguel', 9012345678, 'Calle I, 901', '1986-06-25', 'Sin observaciones', 52000, 9),
('Ramirez', 'Sara', 1230984567, 'Calle J, 123', '1994-10-02', 'Sin observaciones', 48000, 10);

INSERT INTO JUGUETE (nombre, precio, stock) VALUES
('Muñeca Barbie', 20.99, 50),
('Lego Star Wars', 99.99, 30),
('Puzzle 1000 piezas', 15.50, 40),
('Auto a control remoto', 45.00, 20),
('Pelota de fútbol', 25.00, 60),
('Set de plastilina', 10.99, 80),
('Pista de autos Hot Wheels', 55.99, 25),
('Rompecabezas 3D', 30.00, 35),
('Juego de mesa Monopoly', 29.99, 50),
('Avión de juguete', 18.50, 45);
