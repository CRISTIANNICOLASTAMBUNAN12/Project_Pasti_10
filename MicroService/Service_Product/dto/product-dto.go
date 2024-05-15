package dto

type ProductCreateDTO struct {
 
    Name         string  `json:"name" form:"name" binding:"required,min=3,max=255"`
    Description  string  `json:"description" form:"description" binding:"required"`
    Stock        int     `json:"stock" form:"stock" binding:"required"`
    Price        float64 `json:"price" form:"price" binding:"required"`
    WeightUnit   string  `json:"weight_unit" form:"weight_unit" binding:"required,oneof=kilogram gram liter milli meter"`
    Image        string  `json:"image" form:"image" binding:"required"`
    CategoryID   uint    `json:"category_id" form:"category_id" binding:"required"`
    CategoryName string  `json:"category_name" form:"category_name" binding:"required"`
}

type ProductUpdateDTO struct {
    ID          uint   `json:"id" form:"id"`
     Name         string  `json:"name" form:"name" binding:"required,min=3,max=255"`
    Description  string  `json:"description" form:"description" binding:"required"`
    Stock        int     `json:"stock" form:"stock" binding:"required"`
    Price        float64 `json:"price" form:"price" binding:"required"`
    WeightUnit   string  `json:"weight_unit" form:"weight_unit" binding:"required,oneof=kilogram gram liter milli meter"`
    Image        string  `json:"image" form:"image" binding:"required"`
    CategoryID   uint    `json:"category_id" form:"category_id" binding:"required"`
    CategoryName string  `json:"category_name" form:"category_name" binding:"required"`
}