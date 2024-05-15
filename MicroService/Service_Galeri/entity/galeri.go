    package entity

    import "gorm.io/gorm"

    type Galeri struct {
        gorm.Model
        Name        string  `gorm:"type:varchar(255)" json:"name",max=255"`
        Image       string  `gorm:"type:varchar(255)" json:"image" validate:"required,url"`
        Status      *int8          `gorm:"default:0;type:tinyint;null"`
    }
