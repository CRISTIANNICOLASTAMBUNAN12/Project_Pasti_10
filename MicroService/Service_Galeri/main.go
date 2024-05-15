package main

import (
	"github.com/gin-gonic/gin"
	"github.com/tiancious/Service_Galeri/config"
	"github.com/tiancious/Service_Galeri/controller"
	"github.com/tiancious/Service_Galeri/repository"
	"github.com/tiancious/Service_Galeri/service"
	"gorm.io/gorm"
)

var (
	db                *gorm.DB                     = config.SetupDatabaseConnection()
	galeriRepository repository.GaleriRepository = repository.NewGaleriRepository(db)
	GaleriService    service.GaleriService       = service.NewGaleriService(galeriRepository)
	galeriController controller.GaleriController = controller.NewGaleriController(GaleriService)
)

// membuat variable db dengan nilai setup database connection
func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	galeriRoutes := r.Group("/api/galeris")
	{
		galeriRoutes.GET("/", galeriController.All)
		galeriRoutes.POST("/", galeriController.Insert)
		galeriRoutes.GET("/:id", galeriController.FindByID)
		galeriRoutes.PUT("/:id", galeriController.Update)
		galeriRoutes.DELETE("/:id", galeriController.Delete)
	


	}
	r.Run(":8710")
}
