package dto

type OrderCreateDTO struct {
	UserID        uint64  `json:"user_id" binding:"required"`
	Status        string  `json:"status" binding:"required"`
	TotalPrice    float64 `json:"total_price" binding:"required"`
	PaymentStatus uint16  `json:"payment_status" binding:"required"`
}

type OrderUpdateDTO struct {
	ID            uint64  `json:"id" binding:"required"`
	UserID        uint64  `json:"user_id" binding:"required"`
	Status        string  `json:"status" binding:"required"`
	TotalPrice    float64 `json:"total_price" binding:"required"`
	PaymentStatus uint16  `json:"payment_status" binding:"required"`
	SnapToken     string  `json:"snap_token" binding:"required"`
}
