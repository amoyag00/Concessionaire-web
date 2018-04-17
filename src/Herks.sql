
CREATE TABLE Usuario(
nombre VARCHAR(15),
contrasena VARCHAR(15) NOT NULL,
tipo VARCHAR(15) NOT NULL,
PRIMARY KEY(nombre)
);

CREATE TABLE Administrador(
nombreAdm VARCHAR(15),
PRIMARY KEY(nombreAdm),
FOREIGN KEY(nombreAdm) REFERENCES Usuario(nombre)
);

CREATE TABLE Concesionario(
nombreCon VARCHAR(15),
PRIMARY KEY(nombreCon),
FOREIGN KEY(nombreCon) REFERENCES Usuario(nombre)
);

CREATE TABLE Proveedor(
nombrePro VARCHAR(15),
PRIMARY KEY(nombrePro),
FOREIGN KEY(nombrePro) REFERENCES Usuario(nombre)
);

CREATE TABLE Producto(
producto_id INT AUTO_INCREMENT,
nombrePro VARCHAR(15),
nombre VARCHAR(25),
caracteristicas TEXT,
precio INT,
disponible bit,

PRIMARY KEY(producto_id),
FOREIGN KEY(nombrePro) REFERENCES Proveedor(nombrePro)
);

CREATE TABLE Pedido(
pedido_id INT AUTO_INCREMENT,
nombreCon VARCHAR(15),
fecha date,
estado INT,

PRIMARY KEY(pedido_id),
FOREIGN KEY(nombreCon) REFERENCES Concesionario(nombreCon)
);

CREATE TABLE ListaProductos(
producto_id INT,
pedido_id INT,
cantidad SMALLINT,

PRIMARY KEY(pedido_id,producto_id),
FOREIGN KEY(producto_id) REFERENCES Producto(producto_id),
FOREIGN KEY(pedido_id) REFERENCES Pedido(pedido_id)
);

INSERT INTO Usuario VALUES('prov','prov','provider');
INSERT INTO Proveedor VALUES('prov');

INSERT INTO Usuario VALUES('prov2','prov2','provider');
INSERT INTO Proveedor VALUES('prov2');

INSERT INTO Usuario VALUES('seat','seat','concessionaire');
INSERT INTO Concesionario VALUES('seat');

INSERT INTO Usuario VALUES('audi','audi','concessionaire');
INSERT INTO Concesionario VALUES('audi');

INSERT INTO Usuario VALUES('admin','admin','administrator');
INSERT INTO Administrador VALUES('admin');

INSERT INTO Producto(nombrePro,nombre,caracteristicas,precio,disponible) VALUES('prov','seat panda','gasolina',8000,1);
set @idSeatPanda=LAST_INSERT_ID();
INSERT INTO Producto(nombrePro,nombre,caracteristicas,precio,disponible) VALUES('prov','seat cebra','diesel',9000,1);
set @idSeatCebra=LAST_INSERT_ID();
INSERT INTO Producto(nombrePro,nombre,caracteristicas,precio,disponible) VALUES('prov','seat leon','gasolina',7000,1);

INSERT INTO Producto(nombrePro,nombre,caracteristicas,precio,disponible) VALUES('prov2','audi panda','gasolina',17000,1);
set @idAudiPanda=LAST_INSERT_ID();
INSERT INTO Producto(nombrePro,nombre,caracteristicas,precio,disponible) VALUES('prov2','audi cebra','diesel',19000,1);
INSERT INTO Producto(nombrePro,nombre,caracteristicas,precio,disponible) VALUES('prov2','audi leon','gasolina',18000,1);
set @idAudiLeon=LAST_INSERT_ID();

INSERT INTO Pedido(nombreCon,fecha,estado) VALUES('seat','2018-04-15',1);
set @idPedidoSeat=LAST_INSERT_ID();
INSERT INTO ListaProductos  VALUES(@idSeatCebra,@idPedidoSeat,3);
INSERT INTO ListaProductos  VALUES(@idSeatPanda,@idPedidoSeat,10);

INSERT INTO Pedido(nombreCon,fecha,estado) VALUES('audi','2018-04-16',1);
set @idPedidoAudi=LAST_INSERT_ID();
INSERT INTO ListaProductos  VALUES(@idAudiPanda,@idPedidoAudi,5);
INSERT INTO ListaProductos  VALUES(@idAudiLeon,@idPedidoAudi,4);




