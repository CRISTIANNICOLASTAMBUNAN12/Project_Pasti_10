package service

import (
	"log"

	"github.com/tiancious/Service_Galeri/dto"
	"github.com/tiancious/Service_Galeri/entity"
	"github.com/tiancious/Service_Galeri/repository"
	"github.com/mashingan/smapping"
)


type GaleriService interface {
	Insert(b dto.GaleriCreateDTO) entity.Galeri
	Update(b dto.GaleriUpdateDTO) entity.Galeri
	Delete(b entity.Galeri)
	All() []entity.Galeri
	FindByID(galeriID uint64) entity.Galeri
}

type galeriService struct {
	galeriRepository repository.GaleriRepository
}

// NewgaleriService creates a new instance of galeriService
func NewGaleriService(galeriRepository repository.GaleriRepository) GaleriService {
	return &galeriService{
		galeriRepository: galeriRepository,
	}
}

func (service *galeriService) All() []entity.Galeri {
	return service.galeriRepository.All()
}

func (service *galeriService) FindByID(galeriID uint64) entity.Galeri {
	return service.galeriRepository.FindByID(galeriID)
}

func (service *galeriService) Insert(b dto.GaleriCreateDTO) entity.Galeri {
	galeri := entity.Galeri{}
	err := smapping.FillStruct(&galeri, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}

	res := service.galeriRepository.InsertGaleri(galeri)
	return res
}

func (service *galeriService) Update(b dto.GaleriUpdateDTO) entity.Galeri {
	galeri := entity.Galeri{}
	err := smapping.FillStruct(&galeri, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}

	res := service.galeriRepository.UpdateGaleri(galeri)
	return res
}

func (service *galeriService) Delete(b entity.Galeri) {
	service.galeriRepository.DeleteGaleri(b)
}


