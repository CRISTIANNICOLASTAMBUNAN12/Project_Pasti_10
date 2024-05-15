package dto

type SliderCreateDTO struct {
    Name    string `json:"name" form:"name"`
    Image   string `json:"image" form:"image"`
    Status  int8   `json:"status" form:"status"`
}

type SliderUpdateDTO struct {
    ID      uint   `json:"id" form:"id"`
    Name    string `json:"name" form:"name"`
    Image   string `json:"image" form:"image"`
    Status  int8   `json:"status" form:"status"`
}
