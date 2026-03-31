import { Link } from "react-router-dom";
import AuthShell from "../../../components/ui/AuthShell";
import Input from "../../../components/ui/Input";
import Button from "../../../components/ui/Button";
import "../auth.css";

export default function LoginPage() {
  return (
    <>
      <title>Login</title>
      <main className="auth-page">
        <section className="auth-card">
          <div className="auth-header">
            {/* <span className="badge">EduFlow</span> */}
            <h1>Welcome back</h1>
            <p>Sign in to continue your learning journey.</p>
          </div>

          <form className="auth-form">
            <div className="form-group">
              <label htmlFor="login-email">Email</label>
              <input
                id="login-email"
                type="email"
                placeholder="you@example.com"
              />
            </div>

            <div className="form-group">
              <label htmlFor="login-password">Password</label>
              <input
                id="login-password"
                type="password"
                placeholder="Enter your password"
              />
            </div>

            <div className="form-row end">
              <a href="#" className="auth-link">
                Forgot password?
              </a>
            </div>

            <button type="submit" className="btn btn-primary">
              Sign in
            </button>
          </form>

          <div className="auth-footer">
            <p>
              Don't have an account? <Link to="/register">Create one</Link>
            </p>
          </div>
        </section>
      </main>
    </>
  );
}
