package dto

type CartUpdateDTO struct {
	ID           uint `json:"id" form:"id"`
	ProductID uint `json:"product_id"  form:"product_id"binding:"required"`
	ProductImage string `json:"product_image" form:"product_image" binding:"required"`
	ProductName  string `json:"product_name" form:"product_name" binding:"required"`
    Quantity  int  `json:"quantity" form:"quantity"binding:"required"  `
	Price        uint64 `json:"price" form:"price" binding:"required"`
	WeightUnit  string  `json:"weight_unit" form:"weight_unit,oneof=kilogram gram liter milli meter unit"binding:"required"`
    UserID    uint `json:"user_id" form:"user_id" binding:"required"`
}

type CartCreateDTO struct {
    ProductID uint `json:"product_id"  form:"product_id"`
	ProductImage string `json:"product_image" form:"product_image" binding:"required"`
	ProductName  string `json:"product_name" form:"product_name" binding:"required"`
    Quantity  int  `json:"quantity" form:"quantity"`
	WeightUnit  string  `json:"weight_unit" form:"weight_unit,oneof=kilogram gram liter milli meter unit"`
	Price        uint64 `json:"price" form:"price" binding:"required"`
    UserID    uint `json:"user_id" form:"user_id"`
}

