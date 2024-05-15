package entity

import "gorm.io/gorm"

type Cart struct {
    gorm.Model

	ProductID    uint `gorm:"type:int(11)"`
	ProductName  string `gorm:"type:varchar(255)"`
	ProductImage string `gorm:"type:varchar(255)"`
	Quantity     int `gorm:"type:int(11)"`
    WeightUnit  string  `gorm:"type:enum('kilogram', 'gram', 'liter', 'milli','meter','unit')" json:"weight_unit" validate:"required,oneof=kilogram gram liter milli meter unit"`
	Price        uint64 `gorm:"type:int(11)"`
	UserID       uint `gorm:"type:int(11)"`
   
}
