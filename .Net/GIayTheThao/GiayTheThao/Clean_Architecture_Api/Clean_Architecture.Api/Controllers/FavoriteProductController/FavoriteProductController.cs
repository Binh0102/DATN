﻿using Clean_Architecture.Model.Dto.FavoriteProduct;
using Clean_Architecture.Service.FavoriteProduct;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;

namespace Clean_Architecture.Api.Controllers.FavoriteProductController
{
    [Authorize]
    [Route("api/[controller]")]
    [ApiController]
    public class FavoriteProductController : ControllerBase
    {
        private readonly IFavoriteProductService _favoriteProductService;
        public FavoriteProductController(IFavoriteProductService facadeProductService)
        {
            _favoriteProductService = facadeProductService;
        }
        [HttpGet]
        public IActionResult GetAll([FromQuery]int userId)
        {
            var list = _favoriteProductService.GetAll().Where(x=>x.UserId==userId).ToList();
            return Ok(list);
        }
        [HttpPost]
        public IActionResult Add([FromForm]AddVM model)
        {
            var findfr=_favoriteProductService.GetAll().Where(x=>x.ProductId==model.ProductId && x.UserId==model.UserId).FirstOrDefault();
            if (findfr == null)
            {
                var fr = new FavoriteProductDto()
                {
                    ProductId = model.ProductId,
                    UserId = model.UserId
                };
                if (_favoriteProductService.Add(fr))
                {
                    return Ok(new
                    {
                        status = "Add",
                        message = "Thêm Sản Phẩm Yêu Thích Thành Công"
                    });
                }
            }
            else
            {
                if(_favoriteProductService.Delete(findfr.Id))
                {
                    return Ok(new
                    {
                        status = "Delete",
                        message = "Bạn Vừa Bỏ Yêu Thích Sản Phẩm Này"
                    });
                }    
            }    
            return BadRequest("Lỗi");
        }
    }
}
