package controller

import (
	"net/http"

	"github.com/gin-gonic/gin"
	"github.com/tiancious/Service_Orders/dto"
	"github.com/tiancious/Service_Orders/helper"
	"github.com/tiancious/Service_Orders/service"
)

// OrderController is a contract about something that this controller can do
type OrderItemController interface {
	Insert(ctx *gin.Context)
}

type orderItemController struct {
	OrderItemService service.OrderItemService
}

// NewOrderController creates a new instance of AuthController
func NewOrderItemController(OrderItemService service.OrderItemService) OrderItemController {
	return &orderItemController{
		OrderItemService: OrderItemService,
	}
}

func (c *orderItemController) Insert(ctx *gin.Context) {
	var orderItemCreateDTO dto.OrderItemCreateDTO
	errDTO := ctx.ShouldBind(&orderItemCreateDTO)
	if errDTO != nil {
		res := helper.BuildErrorResponse("Failed to process request", errDTO.Error(), helper.EmptyObj{})
		ctx.AbortWithStatusJSON(http.StatusBadRequest, res)
		return
	}

	orderItem := c.OrderItemService.Insert(orderItemCreateDTO)
	response := helper.BuildResponse(true, "OK!", orderItem)
	ctx.JSON(http.StatusCreated, response)
}
