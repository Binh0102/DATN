import axios from "axios";
class ProductService{
    getAll(page)
    {
        return axios.get('http://localhost:5224/api/Product',{
            params: {
                page: page
              }
        });
    }
    getById(id)
    {
        return axios.get('http://localhost:5224/api/Product/'+id)
    }
    update(item)
    {
        return axios.put('http://localhost:5224/api/Product/'+item.ProductId,item,{
            headers: {
                "Content-Type": "multipart/form-data",
              },
        })
    }
    post(item){
        item.ProductId=0
        return axios.post('http://localhost:5224/api/Product/',item,{
            headers: {
                "Content-Type": "multipart/form-data",
              },
        })
    }
    delete(item){
        return axios.delete('http://localhost:5224/api/Product/'+item.ProductId)
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
export default new ProductService();