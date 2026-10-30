CREATE DATABASE IF NOT EXISTS netflix;

-- phim
-- the_loai
-- dien_vien
-- dao_dien
-- nguoi_dung


CREATE TABLE IF NOT EXISTS nguoi_dung (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_dang_nhap VARCHAR(30) NOT NULL,
    mat_khau VARCHAR(30) NOT NULL,
    email VARCHAR(255) NOT NULL,
    ho_ten VARCHAR(40) NOT NULL,
    ngay_sinh DATE NOT NULL,
    so_dien_thoai VARCHAR(10) NOT NULL,
    gioi_tinh ENUM('Nam', 'Nu') NOT NULL
);

CREATE TABLE IF NOT EXISTS the_loai (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_the_loai VARCHAR(30) NOT NULL
);

CREATE TABLE IF NOT EXISTS dien_vien (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_dien_vien VARCHAR(40) NOT NULL,
    nam_sinh DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS dao_dien(
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_dao_dien VARCHAR(40) NOT NULL,
    nam_sinh DATE NOT NULL
);

CREATE TABLE IF NOT EXISTS phim (
    id INT PRIMARY KEY AUTO_INCREMENT,
    ten_phim VARCHAR(50) NOT NULL,
    nam_san_xuat YEAR NOT NULL,
    quoc_gia VARCHAR(40) NOT NULL,
    id_dao_dien INT NOT NULL,
    do_tuoi INT NOT NULL,
    mo_ta VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_dao_dien) REFERENCES dao_dien(id)
);

CREATE TABLE IF NOT EXISTS phim_the_loai(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_phim INT NOT NULL,
    id_the_loai INT NOT NULL,
    FOREIGN KEY (id_phim) REFERENCES phim(id),
    FOREIGN KEY (id_the_loai) REFERENCES the_loai(id)
);

CREATE TABLE IF NOT EXISTS phim_dien_vien(
    id INT PRIMARY KEY AUTO_INCREMENT,
    id_phim INT NOT NULL,
    id_dien_vien INT NOT NULL,
    FOREIGN KEY (id_phim) REFERENCES phim(id),
    FOREIGN KEY (id_dien_vien) REFERENCES dien_vien(id)
);
