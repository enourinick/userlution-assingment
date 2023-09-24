import React, { useState } from "react";
import { useForm, SubmitHandler } from "react-hook-form";
import { get, post } from "../helpers/api";
import { replaceToProducts } from "../helpers/routing";
import Login from "../models/Login";

const LoginPage: React.FC = () => {
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm<Login>();
  const [loginError, setLoginError] = useState(false);

  const onSubmit: SubmitHandler<Login> = async (data) => {
    setLoginError(false);
    get("/api/sanctum/csrf-cookie");
    const response = await post<Login>("/api/login", data);
    if (response.status !== 200) {
      setLoginError(true);
    } else {
        replaceToProducts();
    }
  };

  return (
    <div className="login-container">
      <div className="login-form">
        <h2>Login</h2>
        <form onSubmit={handleSubmit(onSubmit)}>
          <div className="form-group">
            <input
              placeholder="E-mail"
              className={errors.email && "error"}
              {...register("email", { required: true })}
            />
          </div>
          <div className="form-group">
            <input
              placeholder="Password"
              className={errors.password && "error"}
              type="password"
              {...register("password", { required: true })}
            />
          </div>
          {loginError && (
            <div className="error-message">
              We couldn't find a user matching your crendetials at our end!
              Please kindly double check and try again!
            </div>
          )}
          <div className="form-group">
            <button type="submit">Login</button>
          </div>
        </form>
      </div>
    </div>
  );
};

export default LoginPage;
