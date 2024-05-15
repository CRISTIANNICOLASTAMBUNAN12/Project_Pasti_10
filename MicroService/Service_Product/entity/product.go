package entity

import "gorm.io/gorm"

type Product struct {
    gorm.Model
    Name        string  `gorm:"type:varchar(255)" json:"name",max=255"`
    Description string  `gorm:"type:text" json:"description"`
    Price       float64 `gorm:"type:decimal(10,2)" json:"price" validate:"required"`
    Stock       int     `gorm:"type:int" json:"stock" validate:"required"`
    WeightUnit  string  `gorm:"type:enum('kilogram', 'gram', 'liter', 'milli','meter')" json:"weight_unit" validate:"required,oneof=kilogram gram liter milli meter"`
    Image       string  `gorm:"type:varchar(255)" json:"image" validate:"required,url"`
    CategoryID  uint    `gorm:"type:int" json:"category_id" validate:"required"`
    CategoryName string `gorm:"type:varchar(255)" json:"category_name" validate:"required"`
}
