import React, { useEffect, useState } from "react";
import { Link, useParams } from "react-router-dom";
import Product from "../models/Product";
import { get } from "../helpers/api";
import { replaceToLogin, replaceToProducts } from "../helpers/routing";

const ProductDetailsPage: React.FC = () => {
  const { id } = useParams();
  const [product, setProduct] = useState<Product | null>(null);
  const [loading, setLoading] = useState(false);

  const fetchProduct = async () => {
    setLoading(true);
    const response = await get(`/api/product/${id}`);
    if (response.status === 200) {
      setLoading(false);
      const data = await response.json();
      setProduct(data);
    } else if (response.status === 403) {
      replaceToProducts();
    } else if (response.status === 401) {
      replaceToLogin();
    }
  };

  useEffect(() => {
    fetchProduct();
  }, [id]);

  return (
    <div className="product-details-container">
      {product !== null && (
        <div className="product-details">
          <div className="product-image">
            <img src={product.image_url} alt={product.name} />
            <div className="price">
              <span>${(product.price / 100.0).toFixed(2)}</span>
            </div>
          </div>
          <div className="product-info">
            <h1>{product.name}</h1>
            <div className="category">
              <span>Category: {product.category.name}</span>
            </div>
            <div className="description">
              <h2>Description</h2>
              <p>{product.description}</p>
            </div>
          </div>
        </div>
      )}
      {loading && <div className="loading-message">Loading...</div>}
      <div className="back-button">
        <Link to="/products">
          <button>Back</button>
        </Link>
      </div>
    </div>
  );
};

export default ProductDetailsPage;
