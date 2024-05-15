package dto

type CategoryUpdateDTO struct {
    ID    uint   `json:"id" form:"id"`
    Name  string `json:"name" form:"name",max=255"`
    Image string `json:"image" form:"image" binding:"omitempty"`
}

type CategoryCreateDTO struct {
    Name  string `json:"name" form:"name",max=255"`
    Image string `json:"image" form:"image" binding:"omitempty"`
}
