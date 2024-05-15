package main

import (
	"github.com/gin-gonic/gin"
	"github.com/tiancious/Service_Product/config"
	"github.com/tiancious/Service_Product/controller"
	"github.com/tiancious/Service_Product/repository"
	"github.com/tiancious/Service_Product/service"
	"gorm.io/gorm"
)

var (
	db                *gorm.DB                     = config.SetupDatabaseConnection()
	productRepository repository.ProductRepository = repository.NewProductRepository(db)
	categoryService    service.CategoryService      = service.NewCategoryService()
	ProductService    service.ProductService       = service.NewProductService(productRepository, categoryService)
	productController controller.ProductController = controller.NewProductController(ProductService, categoryService)
)

// membuat variable db dengan nilai setup database connection
func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	productRoutes := r.Group("/api/products")
	{
		productRoutes.GET("/", productController.All)
		productRoutes.POST("/", productController.Insert)
		productRoutes.GET("/:id", productController.FindByID)
		productRoutes.PUT("/:id", productController.Update)
		productRoutes.DELETE("/:id", productController.Delete)
		productRoutes.GET("/:id/related", productController.RelatedProducts)


	}
	r.Run(":8999")
}
