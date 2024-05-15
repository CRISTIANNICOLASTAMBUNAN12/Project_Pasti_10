package service

import (
	"log"

	"github.com/tiancious/Service_Slider/dto"
	"github.com/tiancious/Service_Slider/entity"
	"github.com/tiancious/Service_Slider/repository"
	"github.com/mashingan/smapping"
)


type SliderService interface {
	Insert(b dto.SliderCreateDTO) entity.Slider
	Update(b dto.SliderUpdateDTO) entity.Slider
	Delete(b entity.Slider)
	All() []entity.Slider
	FindByID(sliderID uint64) entity.Slider
}

type sliderService struct {
	sliderRepository repository.SliderRepository
}

// NewsliderService creates a new instance of sliderService
func NewSliderService(sliderRepository repository.SliderRepository) SliderService {
	return &sliderService{
		sliderRepository: sliderRepository,
	}
}

func (service *sliderService) All() []entity.Slider {
	return service.sliderRepository.All()
}

func (service *sliderService) FindByID(sliderID uint64) entity.Slider {
	return service.sliderRepository.FindByID(sliderID)
}

func (service *sliderService) Insert(b dto.SliderCreateDTO) entity.Slider {
	slider := entity.Slider{}
	err := smapping.FillStruct(&slider, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}

	res := service.sliderRepository.InsertSlider(slider)
	return res
}

func (service *sliderService) Update(b dto.SliderUpdateDTO) entity.Slider {
	slider := entity.Slider{}
	err := smapping.FillStruct(&slider, smapping.MapFields(&b))
	if err != nil {
		log.Fatalf("Failed map %v", err)
	}

	res := service.sliderRepository.UpdateSlider(slider)
	return res
}

func (service *sliderService) Delete(b entity.Slider) {
	service.sliderRepository.DeleteSlider(b)
}


