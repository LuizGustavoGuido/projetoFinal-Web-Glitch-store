create table users(
cod int AUTO_INCREMENT not null primary key,
username varchar(20) not null,
email varchar(50) UNIQUE not null,
psswd varchar(255) not null,
datainsercao TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);
create table pedido(
id int AUTO_INCREMENT not null primary key,
datapedido TIMESTAMP DEFAULT current_timestamp not null,
cep varchar(9) not null,
valorpedido real not null,
metodopagamento varchar(10) not null,
usercod int not null,
foreign key(usercod) references users(cod)
);
create table item(
id int AUTO_INCREMENT not null primary key,
nome varchar(50) not null,
tipoproduto varchar(40) not null,
categoria varchar(20) not null,
descricao varchar(1800) not null,
preco real not null,
imgpath varchar(75) not null,
parcelas int null,
datainsercao TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);
create table pedidoitem(
idpedido int not null,
iditem int not null,
quantidade int not null,
primary key(idpedido,iditem),
foreign key(idpedido) references pedido(id),
foreign key(iditem) references item(id)
);
insert into users(cod,username,email,psswd) values(1, 'admin', 'glitch.store@gmail.com','$2y$10$unNWl/kh7FhVJ30dXLoQWes/WTACUKmhogK24Cq4S71acL7u3Hs2S');

insert into item(nome,tipoproduto,categoria,descricao,preco,imgpath,parcelas) values
("Gigabyte B760M Aorus Elite", "Placa Mãe", "Hardware", "- Soquete LGA1700: Suporte para processadores Intel® Core™, Pentium® Gold e Celeron® de 14ª, 13ª e 12ª gerações<br>
                - Desempenho incomparável: solução VRM digital híbrida de 6+2+1 fases<br>
                - DDR5 de canal duplo: suporte para módulo de memória XMP de 2 * DIMMs<br>
                - Armazenamento de próxima geração: 2 conectores PCIe 4.0 x4 M.2<br>
                - EZ-Latch: Slot PCIe 4.0x16 com design de liberação rápida<br>
                - Redes rápidas: LAN de 2,5 GbE e Wi-Fi 802.11ac<br>
                - Conectividade estendida: USB-C ® traseiro 5 Gb/s, DP, HDMI, D-Sub<br>
                - Ventilador inteligente 6: possui vários sensores de temperatura, conectores de ventilador híbridos com FAN STOP<br>
                - Q-Flash Plus: Atualize o BIOS sem instalar a CPU, memória e placa gráfica
                - Suporte para DDR5 8000(OC) /7800(OC) /7600(OC) /7400(OC) /7200(OC) /7000(OC) /6800(OC) /6600(OC) / 6400(OC) / 6200( OC) / 6000(OC) / 5800(OC) / 5600(OC) / 5400(OC) / 5200(OC) / 4800 / 4000 módulos de memória MT/s<br>
                - 2 soquetes DIMM DDR5 com suporte para até 96 GB (capacidade DIMM única de 48 GB) de memória do sistema<br>
                - Arquitetura de memória de canal duplo<br>
                - Suporte para módulos de memória DIMM 1Rx8/2Rx8 sem buffer ECC (operar em modo não ECC)<br>
                - Suporte para módulos de memória DIMM 1Rx8/2Rx8/1Rx16 não-ECC sem buffer<br>
                - Suporte para módulos de memória Extreme Memory Profile (XMP)<br>"
, 999.99, "../videos-imagens/placa_mae1.jpg", 10),
("ASRock B450M Steel Legend", "Placa Mãe", "Hardware", "Descrição", 769.99, "../videos-imagens/placa_mae2.jpg", null),
("Mancer B560M-DX", "Placa Mãe", "Hardware", "Descrição", 449.99, "../videos-imagens/placa_mae3.jpg", null),
("AMD Ryzen 7 9800X3D", "Processador", "Hardware", "Descrição", 4199.99, "../videos-imagens/processador1.jpg", null),
("Intel Core I9-14900F", "Processador", "Hardware", "Descrição", 4099.99, "../videos-imagens/processador2.jpg", null),
("Intel Core I5-13400F", "Processador", "Hardware", "Descrição", 1399.99, "../videos-imagens/processador3.jpg", null),
("Pichau Hefesto IV", "PC Gamer", "Computador", "Descrição", 3299.99, "../videos-imagens/pc_gamer1.jpg", null),
("Mancer Afrodite", "PC Gamer", "Computador", "Descrição", 2299.99, "../videos-imagens/pc_gamer2.jpg", null),
("Asus TUF Gaming F15", "Notebook Gamer", "Computador", "Descrição", 5599.99, "../videos-imagens/notebook1.jpg", null);