package service

import (
	"encoding/json"
	"fmt"
	"log"
	"net/http"

	"github.com/tiancious/Service_Product/dto"
	"github.com/tiancious/Service_Product/entity"
	"github.com/tiancious/Service_Product/repository"
	"github.com/mashingan/smapping"
)

// ProductService is a contract about something that this service can do
type ProductService interface {
	Insert(b dto.ProductCreateDTO) entity.Product
	Update(b dto.ProductUpdateDTO) entity.Product
	Delete(b entity.Product)
	All() []entity.Product
	FindByID(productID uint64) entity.Product
	GetRelatedProductsByCategoryID(categoryID uint64) []entity.Product
}

type productService struct {
	productRepository repository.ProductRepository
	categoryService    CategoryService
}

// NewProductService creates a new instance of ProductService
func NewProductService(productRepository repository.ProductRepository,categoryService CategoryService) ProductService {
	return &productService{
		productRepository: productRepository,
		categoryService:    categoryService,
	}
}

func (service *productService) All() []entity.Product {
	return service.productRepository.All()
}

func (service *productService) FindByID(productID uint64) entity.Product {
	return service.productRepository.FindByID(productID)
}

func (service *productService) Insert(b dto.ProductCreateDTO) entity.Product {
	product := entity.Product{}
	err := smapping.FillStruct(&product, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}
	categoryID, err := service.categoryService.GetCategoryID(uint64(b.CategoryID)) // Change 's' to 'service'
	if err != nil {
		log.Fatalf("Failed to get category ID: %v", err)
	}
	product.CategoryID = uint(categoryID) // Change 's' to 'service'

	res := service.productRepository.InsertProduct(product)
	return res
}

func (service *productService) Update(b dto.ProductUpdateDTO) entity.Product {
	product := entity.Product{}
	err := smapping.FillStruct(&product, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}
	categoryID, err := service.categoryService.GetCategoryID(uint64(b.CategoryID)) // Change 's' to 'service'
	if err != nil {
		log.Fatalf("Failed to get category ID: %v", err)
	}
	product.CategoryID = uint(categoryID) // Change 's' to 'service'
	
	res := service.productRepository.UpdateProduct(product)
	return res
}


func (service *productService) Delete(b entity.Product) {
	service.productRepository.DeleteProduct(b)
}
func (service *productService) GetRelatedProductsByCategoryID(categoryID uint64) []entity.Product {
    return service.productRepository.GetRelatedProductsByCategoryID(categoryID)
}
type CategoryService interface {
	GetCategoryID(id uint64) (uint64, error)
}
type categoryService struct{}

func NewCategoryService() CategoryService {
	return &categoryService{}
}

func (cs *categoryService) GetCategoryID(id uint64) (uint64, error) {
	// Replace the URL with the actual endpoint of your category service API
	url := fmt.Sprintf("http://localhost:9000/api/category/%d", id)

	resp, err := http.Get(url)
	if err != nil {
		return 0, err
	}	
	defer resp.Body.Close()

	if resp.StatusCode != http.StatusOK {
		return 0, fmt.Errorf("failed to fetch Category ID: %s", resp.Status)
	}

	var category struct {
		ID uint64 `json:"id"`
	}
	if err := json.NewDecoder(resp.Body).Decode(&category); err != nil {
		return 0, err
	}

	return category.ID, nil
}
