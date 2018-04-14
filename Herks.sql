
CREATE TABLE Usuario(
nombre VARCHAR(15),
contrasena VARCHAR(15) NOT NULL,
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

PRIMARY KEY(pedido_id,nombreCon),
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





