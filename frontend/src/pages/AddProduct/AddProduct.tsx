import { useHistory } from "react-router-dom";
import { useEffect, useState } from "react";
import { Notification } from "../../components";
import Util from "../../utils";
import HTTPRequestBuilder from "../../utils/HTTPRequest/HTTPRequestBuilder";

export const AddProduct = () => {
  const history = useHistory();
  const initialState = {
    productType: '#',
    sku: '',
    price: undefined,
    name: '',
    width: undefined,
    height:undefined,
    length: undefined,
    size: undefined,
    weight: undefined,
    hasResponseError: false,
    inputError: [],
    response: {
      error: '',
      errors: {},
      message: '',
    },
    save: false,
  }
  const [state, setState] = useState(initialState);
  const {
    productType,
    hasResponseError,
    inputError,
    save,
    sku,
    response,
  } = state;

  useEffect(() => {
    let call = true;

    async function postData () {
      const result = await new HTTPRequestBuilder()
      .withURL('http://localhost:9000/products')
      .method('post')
      .queryParams(undefined)
      .headers({
        'content-type': 'application/json',
      })
      .data(state)
      .build()
      .send();

      setState({
        ...state,
        save: false,
        hasResponseError: result?.error || result?.errors,
        response: result,
      })
    };

    if (save) {
      postData();
    }

    return () => {
      call = false;
    }
    
  }, [save]);

  const cancelAddProduct = (evt) => {
    evt.preventDefault();
    history.push('/');
  };

  const handleChange = (e) => {
    setState({
      ...state,
      [e.target.id]: e.target.value,
      inputError: [],
      hasResponseError: false,
      save: false,
      response: {
        error: '',
        errors: {},
        message: '',
      },
    })
  }

  const onSave = (e) => {
    e.preventDefault();
    const errors: any[] = Util.validateProductInput(state);

    if (errors.length >= 1) {
      setState({
        ...state,
        inputError: errors,
        hasResponseError: false,
        save: false,
        response: {
          error: '',
          errors: {},
          message: '',
        },
      })
      return;
    }

    setState({
      ...state,
      save: true,
    })
  }
  
  return (
    <>
      <header id="header">
        <div id="title-div">
          <h2>Product Add</h2>
          <div id="action-btn" className="flex-column">
            <button className="btn btn-outline-success" onClick={onSave}>Save</button>
            <button className="btn btn-outline-danger" onClick={cancelAddProduct}>Cancel</button>
          </div>
        </div>
        <hr/>
      </header>
      <main id="main-content">
        <form id="product-form" action="">
          <div className="container-fluid">
            <div className="flex-column form-input-group">
              {!response && <Notification text={`❌ Error! Unable to add new product with SKU '${sku}'.`} type='err' />}
              {(!hasResponseError && (response?.message && response?.message !== '')) && <Notification text={`✅ ${response?.message}`} type='success' />}
              <div className="input form-group">
                <label htmlFor="sku">SKU </label>
                <div>
                  <input className={'form-control' + (inputError.includes('sku') ? ' err' : '')} onChange={handleChange} type="text" placeholder=" #sku" name="sku" id="sku" required />
                  <p className={'form-text' + (inputError.includes('sku') ? ' err-text' : ' hide')}>*Please, provide SKU*</p>
                </div>
              </div>
              <div className="input form-group">
                <label htmlFor="name">Name </label>
                <div>
                  <input className={'form-control' + (inputError.includes('name') ? ' err' : '')} onChange={handleChange} type="text" placeholder=" #name" name="name" id="name" required />
                  <p className={'form-text' + (inputError.includes('name') ? ' err-text' : ' hide')}>*Please, provide Name*</p>
                </div>
              </div>
              <div className="input form-group">
                <label htmlFor="price">Price ($) </label>
                <div>
                  <input className={'form-control' + (inputError.includes('price') ? ' err' : '')} onChange={handleChange} min={0} type="number" placeholder=" #price" name="price" id="price" required />
                  <p className={'form-text' + (inputError.includes('price') ? ' err-text' : ' hide')}>*Please, provide Price (Number type)*</p>
                </div>
              </div>
              <div className="input form-group">
                <label htmlFor="productType">Type Switcher </label>
                  <select onChange={handleChange} className={'form-control' + (inputError.includes('productType') ? ' err' : '')} name="productType" id="productType" required>
                    <option value="#">Choose Product Type</option>
                    <option value="DVD" id="DVD">DVD</option>
                    <option value="Furniture" id="Furniture">Furniture</option>
                    <option value="Book" id="Book">Book</option>
                  </select>
              </div>
              {(productType === 'DVD') && <div id="dvd-text">
                <div className="input form-group">
                  <label htmlFor="size">Size (MB) </label>
                  <div>
                    <input className={'form-control' + (inputError.includes('size') ? ' err' : '')} onChange={handleChange} min={0} type="number" placeholder=" #size" name="size" id="size" required />
                    <p className={'form-text' + (inputError.includes('size') ? ' err-text' : '')}>*Please, provide size (Number type)*</p>
                  </div>
                </div>
              </div>}
                {(productType === 'Book') && <div id="book-text">
                  <div className="input form-group">
                    <label htmlFor="weight">Weight (KG) </label>
                  <div>
                    <input className={'form-control' + (inputError.includes('weight') ? ' err' : '')} onChange={handleChange} min={0} type="number" placeholder=" #weight" name="weight" id="weight" required />
                    <p className={'form-text' + (inputError.includes('weight') ? ' err-text' : '')}>*Please, provide weight (Number type)*</p>
                  </div>
                </div>
              </div>}
                {(productType === 'Furniture') && <div id="furniture-text">
                  <div className="input form-group">
                    <label htmlFor="height">Height (CM) </label>
                  <div>
                    <input className={'form-control' + (inputError.includes('height') ? ' err' : '')} onChange={handleChange} min={0} type="number" placeholder=" #height" name="height" id="height" required />
                  </div>
                  </div>
                <div className="input form-group">
                  <label htmlFor="width">Width (CM) </label>
                  <div>
                    <input className={'form-control' + (inputError.includes('width') ? ' err' : '')} onChange={handleChange} min={0} type="number" placeholder=" #width" name="width" id="width" required />
                  </div>
                </div>
                <div className="input form-group">
                  <label htmlFor="length">Length (CM) </label>
                  <div>
                    <input className={'form-control' + (inputError.includes('length') ? ' err' : '')} onChange={handleChange} min={0} type="number" placeholder=" #length" name="length" id="length" required />
                    <p
                      className={
                        'form-text' + ((inputError.includes('length') ||
                        inputError.includes('height') ||
                        (inputError.includes('width')) ? ' err-text' : ''))
                      }>*Please, provide dimensions in HxWxL format. (Number type)*
                    </p>
                  </div>
                </div>
              </div>}
            </div>
          </div>
        </form>
      </main>
      </>
  )
};