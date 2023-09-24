import React, { useState, useEffect } from "react";
import { Link } from "react-router-dom";
import { post, get } from "../helpers/api";
import { replaceToLogin } from "../helpers/routing";
import Pagination from "../models/Pagination";

interface Product {
  id: number;
  name: string;
  category: string;
  addedDate: string;
  imageUrl: string;
}

interface User {
  name: string;
}

const ProductListPage: React.FC = () => {
  const [products, setProducts] = useState<Pagination<Product>>({
    data: [],
    to: 0,
    total: 0,
    from: 0,
    per_page: 0,
    current_page: 0,
    last_page: 0,
  });
  const [loading, setLoading] = useState(false);
  const [user, setUser] = useState<User>({ name: "" });

  const fetchProducts = async () => {
    setLoading(true);
    const response = await get(
      `/api/product?page=${products.current_page + 1}`,
    );

    if (response.status === 200) {
      const data = await response.json();
      setProducts({
        data: [...products.data, ...data.data],
        to: data.to,
        total: data.total,
        from: data.from,
        per_page: data.per_page,
        current_page: data.current_page,
        last_page: data.last_page,
      });
    }
    setLoading(false);
  };

  const fetchUser = async () => {
    const response = await get("/api/user");

    if (response.status === 200) {
      const data = await response.json();
      setUser(data);
    } else {
      replaceToLogin();
    }
  };

  useEffect(() => {
    fetchUser();
    fetchProducts();
  }, []);

  const handleLogout = async () => {
    await post("/api/logout", {});

    replaceToLogin();
  };

  return (
    <div className="product-list-container">
      <div className="user-header">
        <h1>Welcome, {user.name}</h1>
        <button onClick={handleLogout} className="logout-button">
          Logout
        </button>
      </div>
      <div className="product-list">
        {products.data.map((product: any) => (
          <Link
            to={`/products/${product.id}`}
            className="product-card"
            key={product.id}
          >
            <img src={product.image_url} alt={product.name} />
            <h2>{product.name}</h2>
            <p>{product.category.name}</p>
            <p>${(product.price / 100.0).toFixed(2)}</p>
          </Link>
        ))}
      </div>
      {loading && <div className="loading-message">Loading...</div>}
      <div>
        {products.current_page < products.last_page && !loading && (
          <button onClick={fetchProducts} className="loadmore-button">load more</button>
        )}
      </div>
    </div>
  );
};

export default ProductListPage;
