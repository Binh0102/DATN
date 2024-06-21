import axios from "axios";
class CategoryService{
    getAll(page)
    {
        return axios.get('http://localhost:5224/api/Category',{
            params: {
                page: page
              }
        });
    }
    getById(id)
    {
        return axios.get('http://localhost:5224/api/Category/'+id)
    }
    update(item)
    {
        return axios.put('http://localhost:5224/api/Category/'+item.CategoryId,item)
    }
    post(item){
        item.CategoryId=0
        return axios.post('http://localhost:5224/api/Category/',item)
    }
    delete(item){
        return axios.delete('http://localhost:5224/api/Category/'+item.CategoryId)
    }
    search(string)
    {
        return axios.get('http://localhost:5224/api/Category/search',{
            params: {
                key: string
              }
        });
    }
}
export default new CategoryService();