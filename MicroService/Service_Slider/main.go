package main

import (
	"github.com/gin-gonic/gin"
	"github.com/tiancious/Service_Slider/config"
	"github.com/tiancious/Service_Slider/controller"
	"github.com/tiancious/Service_Slider/repository"
	"github.com/tiancious/Service_Slider/service"
	"gorm.io/gorm"
)

var (
	db                *gorm.DB                     = config.SetupDatabaseConnection()
	sliderRepository repository.SliderRepository = repository.NewSliderRepository(db)
	SliderService    service.SliderService       = service.NewSliderService(sliderRepository)
	sliderController controller.SliderController = controller.NewSliderController(SliderService)
)

// membuat variable db dengan nilai setup database connection
func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	sliderRoutes := r.Group("/api/sliders")
	{
		sliderRoutes.GET("/", sliderController.All)
		sliderRoutes.POST("/", sliderController.Insert)
		sliderRoutes.GET("/:id", sliderController.FindByID)
		sliderRoutes.PUT("/:id", sliderController.Update)
		sliderRoutes.DELETE("/:id", sliderController.Delete)
	


	}
	r.Run(":8700")
}
