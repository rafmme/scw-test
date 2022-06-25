import { useState, useEffect } from "react";
import { useHistory } from "react-router-dom";
import { ProductCard } from '../../components';
import HTTPRequestBuilder from "../../utils/HTTPRequest/HTTPRequestBuilder";

export const Home = () => {
  const initialState = {
    results: [],
    executeDeletion: false,
    listOfProductsForDeletion: [],
  }
  const history = useHistory();
  const [state, setState] = useState(initialState);
  const { executeDeletion, results, listOfProductsForDeletion } = state;

  useEffect(() => {
    let call = true;

    async function executeHttpRequest (url: string, method: string) {
      const response = await new HTTPRequestBuilder()
      .withURL(url)
      .method(method)
      .queryParams(undefined)
      .headers(undefined)
      .data(undefined)
      .build()
      .send();

      setState({
        ...state,
        executeDeletion: method.toLowerCase() === 'get' ? false : executeDeletion,
        listOfProductsForDeletion: method.toLowerCase() === 'get' ? [] : listOfProductsForDeletion,
        results: method.toLowerCase() === 'get' ? response?.products : results,
      });
    };

    if (executeDeletion && listOfProductsForDeletion.length > 0) {
      listOfProductsForDeletion.forEach(sku => {
        executeHttpRequest(`/products/${sku}`, 'DELETE');
      });
      history.go(0);
    }

    executeHttpRequest('/products', 'GET');

    return () => {
      call = false;
    }
  }, [executeDeletion]);

  const visitAddProductPage = (evt) => {
    evt.preventDefault();
    history.push('/add-product');
  };

  const onChecked = (e, sku) => {
    e.preventDefault();
    
    if (e.target.checked) {
      listOfProductsForDeletion.push(sku);

      setState({
        ...state,
        executeDeletion: false,
        listOfProductsForDeletion,
      });
    } else {
      const skuList = listOfProductsForDeletion.filter(productSku => sku !== productSku);

      setState({
        ...state,
        executeDeletion: false,
        listOfProductsForDeletion: skuList,
      });
    }
  };

  const handleMassDeletion = (e) => {
    e.preventDefault();
    if (listOfProductsForDeletion.length < 1) {
      return;
    }

    setState({
      ...state,
      executeDeletion: true,
    });
  };

  return (
    <>
      <header id="header">
        <div id="title-div">
          <h2>Product List</h2>
          <div id="action-btn" className="flex-column">
              <button className="btn btn-outline-success" onClick={visitAddProductPage}>ADD</button>
              <button className="btn btn-outline-danger" onClick={handleMassDeletion}>MASS DELETE</button>
          </div>
        </div>
        <hr/>
      </header>
      <main id="main-content">
        <section>
          <div className="container-fluid">
            <div className="row">
              {results.length < 1 && <h3 style={{ textAlign: 'center' }}>No Products added yet!</h3>}
              {results.map((product: any, i: number) => {
                return <ProductCard
                  key = {i}
                  onCheck = {onChecked}
                  sku = {product.sku}
                  name = {product.name}
                  price = {product.price}
                  size = {product.size}
                  height = {product.height}
                  weight = {product.weight}
                  length = {product.length}
                  width = {product.width}
              />
            })}
            </div>
          </div>
        </section>
      </main>
    </>
  );
};
  
