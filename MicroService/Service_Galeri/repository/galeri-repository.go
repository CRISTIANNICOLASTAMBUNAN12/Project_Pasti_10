package repository

import (
	"github.com/tiancious/Service_Galeri/entity"
	"gorm.io/gorm"
)

type GaleriRepository interface {
	InsertGaleri(galeri entity.Galeri) entity.Galeri
	UpdateGaleri(galeri entity.Galeri) entity.Galeri
	All() []entity.Galeri
	FindByID(galeriID uint64) entity.Galeri
	DeleteGaleri(galeri entity.Galeri)
}

type galeriConnection struct {
	connection *gorm.DB
}

func NewGaleriRepository(db *gorm.DB) GaleriRepository {
	return &galeriConnection{
		connection: db,
	}
}

func (db *galeriConnection) InsertGaleri(galeri entity.Galeri) entity.Galeri {
	db.connection.Save(&galeri)
	return galeri
}

func (db *galeriConnection) UpdateGaleri(galeri entity.Galeri) entity.Galeri {
	db.connection.Save(&galeri)
	return galeri
}

func (db *galeriConnection) All() []entity.Galeri {
	var galeris []entity.Galeri
	db.connection.Find(&galeris)
	return galeris
}

func (db *galeriConnection) FindByID(galeriID uint64) entity.Galeri {
	var galeri entity.Galeri
	db.connection.Find(&galeri, galeriID)
	return galeri
}

func (db *galeriConnection) DeleteGaleri(galeri entity.Galeri) {
	db.connection.Delete(&galeri)
}
