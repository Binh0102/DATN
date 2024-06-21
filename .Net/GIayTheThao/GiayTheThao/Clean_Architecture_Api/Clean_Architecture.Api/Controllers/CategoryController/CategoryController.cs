using Clean_Architecture.Model.Dto.Category;
using Clean_Architecture.Service.Category;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Http;
using Microsoft.AspNetCore.Mvc;

namespace Clean_Architecture.Api.Controllers.CategoryController
{
    [Route("api/[controller]")]
    [ApiController]
    public class CategoryController : ControllerBase
    {
        private readonly ICategoryService _categoryService;
        public CategoryController(ICategoryService categoryService)
        {
            _categoryService = categoryService;
        }
        [HttpGet("search")]
        public IActionResult SearchCategories(string key)
        {
            return Ok(_categoryService.Search(key));
        }
        [HttpGet]
        public IActionResult GetCategories([FromQuery] int page)
        {
            if(page==-1)
            {
                return Ok(_categoryService.GetAll());
            }
            int begin;
            if (page<=1)
            {
                begin = 0;
            }
            else
            {
                begin = (page * 10) - 10;
            }    
            return Ok(_categoryService.GetAll().Skip(begin).Take(10));

        }
        [HttpGet("{id}")]
        public IActionResult GetCategoriesById(int id)
        {
            var category = _categoryService.GetById(id);
            if (category == null)
            {
                return NotFound();
            }
            return Ok(category);
        }
        [HttpPost]
        public IActionResult PostCategory(CategoryDto category)
        {
            if (_categoryService.Add(category))
            {
                return CreatedAtAction("GetCategoriesById", new { id = category.CategoryId }, category);
            }
            return Ok("Danh Mục Sản Phẩm Đã Tồn Tại");
        }
        [HttpPut("{id}")]
        public IActionResult PutCategory(CategoryDto category)
        {
            if (_categoryService.Update(category))
            {
                return NoContent();
            }
            return NotFound();
        }
        [HttpDelete("{id}")]
        public IActionResult DeleteCategory(int id)
        {
            if (_categoryService.Delete(id))
            {
                return NoContent();
            }
            return NotFound("Không Thể Xóa Vì Loại Sản Phẩm Này Không Tồn Tại");
        }
    }
}
