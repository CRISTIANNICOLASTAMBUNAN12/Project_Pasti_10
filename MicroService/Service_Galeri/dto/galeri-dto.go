package dto

type GaleriCreateDTO struct {
    Name    string `json:"name" form:"name"`
    Image   string `json:"image" form:"image"`
    Status  int8   `json:"status" form:"status"`
}

type GaleriUpdateDTO struct {
    ID      uint   `json:"id" form:"id"`
    Name    string `json:"name" form:"name"`
    Image   string `json:"image" form:"image"`
    Status  int8   `json:"status" form:"status"`
}
