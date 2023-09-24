import React from "react";
import { Link, useRouteError } from "react-router-dom";

const ErrorPage: React.FC = () => {
  const error = useRouteError();
  console.error(error);
  return (
    <div className="error-page-container">
      <div className="error-content">
        <h1>Oops! Something went wrong :'(</h1>
        <p>Probably you should go to our home page!</p>
        <Link to="/products" replace>
          <button>Back to Home</button>
        </Link>
      </div>
    </div>
  );
};

export default ErrorPage;
