type ProductCardProps = {
  sku: string,
  name: string,
  price: number,
  size?: string,
  height?: number,
  weight?: number,
  width?: number,
  length?: number,
};

export const ProductCard = ({sku, name, price, size, height, weight, width, length }: ProductCardProps) => {

  return (
    <div className="col-md-3">
      <div className="card mb-3 shadow-sm">
        <div className="product">
            <input type="checkbox" className="delete-checkbox" id="" />
            <div className="flex-column prod-info">
              <p>{sku}</p>
              <p>{name}</p>
              <p>{`${price}$`}</p>
              {size && <p>Size: {`${size}`} MB</p>}
              {weight && <p>Weight: {`${weight}`} KG</p>}
              {(height && width && length) && <p>Dimensions: {`${height}x${width}x${length}`} KG</p>}
            </div>
        </div>
      </div>
    </div>
  )
};

