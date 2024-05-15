package controller

import (
    "net/http"
    "strconv"

    "github.com/gin-gonic/gin"
    "github.com/tiancious/Service_Cart/dto"
    "github.com/tiancious/Service_Cart/entity"
    "github.com/tiancious/Service_Cart/helper"
    "github.com/tiancious/Service_Cart/service"
)

// CartController is a contract about something that this controller can do
type CartController interface {
	All(ctx *gin.Context)
	Insert(ctx *gin.Context)
	Update(ctx *gin.Context)
	Delete(ctx *gin.Context)
}

type cartController struct {
	CartService service.CartService
}

// NewCartController creates a new instance of AuthController
func NewCartController(CartService service.CartService) CartController {
	return &cartController{
		CartService: CartService,
	}
}

func (c *cartController) All(ctx *gin.Context) {
	// get carts where body request ID == carts.user_id
	userID, err := strconv.ParseUint(ctx.Query("user_id"), 0, 0)
	if err != nil {
		res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	carts := c.CartService.All(userID)
	ctx.JSON(http.StatusOK,carts)
}

func (c *cartController) Insert(ctx *gin.Context) {
	var cartCreateDTO dto.CartCreateDTO
	errDTO := ctx.ShouldBind(&cartCreateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.JSON(http.StatusBadRequest, res)
		return
	}
	result := c.CartService.Insert(cartCreateDTO)
	response := helper.BuildResponse(true, "OK!", result)
	ctx.JSON(http.StatusOK, response)
}

func (c *cartController) Update(ctx *gin.Context) {
    var cartUpdateDTO dto.CartUpdateDTO
    errDTO := ctx.ShouldBind(&cartUpdateDTO)
    if errDTO != nil {
        res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    idStr := ctx.Param("id")
    id, errID := strconv.ParseUint(idStr, 10, 64) // Assuming base 10, 64-bit unsigned integer
    if errID != nil {
        res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    cartUpdateDTO.ID = uint(id) // Convert uint64 to uint
    result := c.CartService.Update(cartUpdateDTO)
    response := helper.BuildResponse(true, "OK!", result)
    ctx.JSON(http.StatusOK, response)
}

func (c *cartController) Delete(ctx *gin.Context) {
    var cart entity.Cart
    idStr := ctx.Param("id")
    id, errID := strconv.ParseUint(idStr, 10, 64) // Assuming base 10, 64-bit unsigned integer
    if errID != nil {
        res := helper.BuildErrorResponse("Failed to get ID", "No param ID were found", helper.EmptyObj{})
        ctx.JSON(http.StatusBadRequest, res)
        return
    }
    cart.ID = uint(id) // Convert uint64 to uint
    c.CartService.Delete(cart)
    res := helper.BuildResponse(true, "Deleted", helper.EmptyObj{})
    ctx.JSON(http.StatusOK, res)
}
