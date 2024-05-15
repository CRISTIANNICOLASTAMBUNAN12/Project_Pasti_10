package repository

import (
	"github.com/tiancious/Service_Slider/entity"
	"gorm.io/gorm"
)

type SliderRepository interface {
	InsertSlider(slider entity.Slider) entity.Slider
	UpdateSlider(slider entity.Slider) entity.Slider
	All() []entity.Slider
	FindByID(SliderID uint64) entity.Slider
	DeleteSlider(slider entity.Slider)
}

type sliderConnection struct {
	connection *gorm.DB
}

func NewSliderRepository(db *gorm.DB) SliderRepository {
	return &sliderConnection{
		connection: db,
	}
}

func (db *sliderConnection) InsertSlider(slider entity.Slider) entity.Slider {
	db.connection.Save(&slider)
	return slider
}

func (db *sliderConnection) UpdateSlider(slider entity.Slider) entity.Slider {
	db.connection.Save(&slider)
	return slider
}

func (db *sliderConnection) All() []entity.Slider {
	var sliders []entity.Slider
	db.connection.Find(&sliders)
	return sliders
}

func (db *sliderConnection) FindByID(sliderID uint64) entity.Slider {
	var slider entity.Slider
	db.connection.Find(&slider, sliderID)
	return slider
}

func (db *sliderConnection) DeleteSlider(slider entity.Slider) {
	db.connection.Delete(&slider)
}
