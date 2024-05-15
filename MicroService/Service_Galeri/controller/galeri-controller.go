package controller

import (
    "net/http"
    "strconv"

    "github.com/gin-gonic/gin"
    "github.com/tiancious/Service_Galeri/dto"
    "github.com/tiancious/Service_Galeri/entity"
    "github.com/tiancious/Service_Galeri/helper"
    "github.com/tiancious/Service_Galeri/service"
)

// galeriController is a contract about something that this controller can do
type GaleriController interface {
    All(ctx *gin.Context)
    FindByID(ctx *gin.Context)
    Insert(ctx *gin.Context)
    Update(ctx *gin.Context)
    Delete(ctx *gin.Context)
}

type galeriController struct {
    GaleriService service.GaleriService
}


func NewGaleriController(galeriService service.GaleriService) GaleriController {
    return &galeriController{
       GaleriService: galeriService,
    }
}

func (sc *galeriController) All(ctx *gin.Context) {
    galeris := sc.GaleriService.All()
    ctx.JSON(http.StatusOK, galeris)
}

func (sc *galeriController) FindByID(ctx *gin.Context) {
    idStr := ctx.Param("id")
    id, err := strconv.ParseUint(idStr, 10, 64)
    if err != nil {
        res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }

    galeri := sc.GaleriService.FindByID(id)
    if galeri.ID == 0 {
        res := helper.BuildErrorResponse("Data not found", "No data with given ID", helper.EmptyObj{})
        ctx.JSON(http.StatusNotFound, res)
        return
    }

    ctx.JSON(http.StatusOK, galeri)
}

func (sc *galeriController) Insert(ctx *gin.Context) {
    var galeriCreateDTO dto.GaleriCreateDTO
    errDTO := ctx.ShouldBind(&galeriCreateDTO)
    if errDTO != nil {
        res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    result := sc.GaleriService.Insert(galeriCreateDTO)
    response := helper.BuildResponse(true, "OK!", result)
    ctx.JSON(http.StatusCreated, response)
}

func (sc *galeriController) Update(ctx *gin.Context) {
    var galeriUpdateDTO dto.GaleriUpdateDTO
    errDTO := ctx.ShouldBind(&galeriUpdateDTO)
    if errDTO != nil {
        res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    idStr := ctx.Param("id")
    id, errID := strconv.ParseUint(idStr, 10, 64)
    if errID != nil {
        res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    galeriUpdateDTO.ID = uint(id)
    result := sc.GaleriService.Update(galeriUpdateDTO)
    response := helper.BuildResponse(true, "OK!", result)
    ctx.JSON(http.StatusOK, response)
}

func (sc *galeriController) Delete(ctx *gin.Context) {
    var galeri entity.Galeri
    idStr := ctx.Param("id")
    id, err := strconv.ParseUint(idStr, 10, 64)
    if err != nil {
        res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    galeri.ID = uint(id)
    sc.GaleriService.Delete(galeri)
    res := helper.BuildResponse(true, "Deleted", helper.EmptyObj{})
    ctx.JSON(http.StatusOK, res)
}
