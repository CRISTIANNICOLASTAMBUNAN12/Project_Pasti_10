package entity

import "gorm.io/gorm"

type Order struct {
	gorm.Model
	ID            uint64  `gorm:"primary_key:auto_increment" json:"id"`
	Code          string  `gorm:"type:varchar(255)" json:"code"`
	UserID        uint64  `gorm:"type:bigint(20)" json:"user_id"`
	Status        string  `gorm:"type:enum('pending','approved','rejected','canceled')" json:"status"`
	TotalPrice    float64 `gorm:"type:int" json:"total_price"`
	PaymentStatus uint16  `gorm:"type:enum('1','2','3','4')" json:"payment_status"`
	SnapToken     string  `gorm:"type:text" json:"snap_token"`
	OrderItems    []OrderItem
}
