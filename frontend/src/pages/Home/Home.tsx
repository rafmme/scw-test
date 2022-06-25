import { useRef, useState, useEffect } from "react";
import { useHistory } from "react-router-dom";
import { ProductCard } from '../../components';
import HTTPRequestBuilder from "../../utils/HTTPRequest/HTTPRequestBuilder";

export const Home = () => {
  const initialState = {
    results: [],
  }
  const history = useHistory();
  const [state, setState] = useState(initialState);

  useEffect(() => {
    let call = true;
    async function fetchData () {
      const response = await new HTTPRequestBuilder()
      .withURL('http://localhost:9000/products')
      .method('get')
      .queryParams(undefined)
      .headers(undefined)
      .data(undefined)
      .build()
      .send();

      setState({
        ...state,
        results: response?.products || [],
      })
    };

    fetchData();

    return () => {
      call = false;
    }
  }, []);

  const visitAddProductPage = (evt) => {
    evt.preventDefault();
    history.push('/add-product');
  };

  return (
    <>
      <header id="header">
        <div id="title-div">
          <h2>Product List</h2>
          <div id="action-btn" className="flex-column">
              <button className="btn btn-outline-success" onClick={visitAddProductPage}>ADD</button>
              <button className="btn btn-outline-danger">MASS DELETE</button>
          </div>
        </div>
        <hr/>
      </header>
      <main id="main-content">
        <section>
          <div className="container-fluid">
            <div className="row">
              {state.results.length < 1 && <h3 style={{ textAlign: 'center' }}>No Products added yet!</h3>}
              {state.results.map((product: any, i: number) => {
                return <ProductCard
                  key = {i}
                  sku = {product.sku}
                  name = {product.name}
                  price = {product.price}
                  size = {product.size}
                  height = {product.height}
                  weight = {product.weight}
                  length = {product.length}
              />
            })}
            </div>
          </div>
        </section>
      </main>
    </>
  );
};
  
