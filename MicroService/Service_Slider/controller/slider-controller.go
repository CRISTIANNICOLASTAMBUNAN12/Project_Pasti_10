package controller

import (
    "net/http"
    "strconv"

    "github.com/gin-gonic/gin"
    "github.com/tiancious/Service_Slider/dto"
    "github.com/tiancious/Service_Slider/entity"
    "github.com/tiancious/Service_Slider/helper"
    "github.com/tiancious/Service_Slider/service"
)

// SliderController is a contract about something that this controller can do
type SliderController interface {
    All(ctx *gin.Context)
    FindByID(ctx *gin.Context)
    Insert(ctx *gin.Context)
    Update(ctx *gin.Context)
    Delete(ctx *gin.Context)
}

type sliderController struct {
    SliderService service.SliderService
}

// NewSliderController creates a new instance of SliderController
func NewSliderController(sliderService service.SliderService) SliderController {
    return &sliderController{
        SliderService: sliderService,
    }
}

func (sc *sliderController) All(ctx *gin.Context) {
    sliders := sc.SliderService.All()
    ctx.JSON(http.StatusOK, sliders)
}


func (sc *sliderController) FindByID(ctx *gin.Context) {
    idStr := ctx.Param("id")
    id, err := strconv.ParseUint(idStr, 10, 64)
    if err != nil {
        res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }

    slider := sc.SliderService.FindByID(id)
    if slider.ID == 0 {
        res := helper.BuildErrorResponse("Data not found", "No data with given ID", helper.EmptyObj{})
        ctx.JSON(http.StatusNotFound, res)
        return
    }

    ctx.JSON(http.StatusOK, slider)
}

func (sc *sliderController) Insert(ctx *gin.Context) {
    var sliderCreateDTO dto.SliderCreateDTO
    errDTO := ctx.ShouldBind(&sliderCreateDTO)
    if errDTO != nil {
        res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    result := sc.SliderService.Insert(sliderCreateDTO)
    response := helper.BuildResponse(true, "OK!", result)
    ctx.JSON(http.StatusCreated, response)
}

func (sc *sliderController) Update(ctx *gin.Context) {
    var sliderUpdateDTO dto.SliderUpdateDTO
    errDTO := ctx.ShouldBind(&sliderUpdateDTO)
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
    sliderUpdateDTO.ID = uint(id)
    result := sc.SliderService.Update(sliderUpdateDTO)
    response := helper.BuildResponse(true, "OK!", result)
    ctx.JSON(http.StatusOK, response)
}

func (sc *sliderController) Delete(ctx *gin.Context) {
    var slider entity.Slider
    idStr := ctx.Param("id")
    id, err := strconv.ParseUint(idStr, 10, 64)
    if err != nil {
        res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    slider.ID = uint(id)
    sc.SliderService.Delete(slider)
    res := helper.BuildResponse(true, "Deleted", helper.EmptyObj{})
    ctx.JSON(http.StatusOK, res)
}
