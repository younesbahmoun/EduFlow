import { useState } from "react";
import { Link } from "react-router-dom";
import "../auth.css";

export default function RegisterPage() {
  const [role, setRole] = useState("student");

  return (
    <>
      <title>Register</title>
      <main className="auth-page">
        <section className="auth-card">
          <div className="auth-header">
            {/* <span className="badge">EduFlow</span> */}
            <h1>Create account</h1>
            <p>Join EduFlow as a student or teacher.</p>
          </div>

          <form className="auth-form">
            <div className="grid-2">
              <div className="form-group">
                <label htmlFor="nom">Nom</label>
                <input id="nom" type="text" placeholder="Bahmoun" />
              </div>

              <div className="form-group">
                <label htmlFor="prenom">Prénom</label>
                <input id="prenom" type="text" placeholder="Younes" />
              </div>
            </div>

            <div className="form-group">
              <label>Choose your role</label>

              <div className="role-grid">
                <button
                  type="button"
                  className={`role-card ${role === "student" ? "active" : ""}`}
                  onClick={() => setRole("student")}
                >
                  <span className="role-title">Student</span>
                  <span className="role-text">
                    Explore courses, save favorites, and get recommendations.
                  </span>
                </button>

                <button
                  type="button"
                  className={`role-card ${role === "teacher" ? "active" : ""}`}
                  onClick={() => setRole("teacher")}
                >
                  <span className="role-title">Teacher</span>
                  <span className="role-text">
                    Create courses, manage groups, and track performance.
                  </span>
                </button>
              </div>
            </div>

            <div className="form-group">
              <label htmlFor="register-email">Email</label>
              <input
                id="register-email"
                type="email"
                placeholder="you@example.com"
              />
            </div>

            <div className="form-group">
              <label htmlFor="register-password">Password</label>
              <input
                id="register-password"
                type="password"
                placeholder="Create a password"
              />
            </div>

            <div className="form-group">
              <label htmlFor="register-password-confirm">
                Confirm Password
              </label>
              <input
                id="register-password-confirm"
                type="password"
                placeholder="Repeat your password"
              />
            </div>

            <button type="submit" className="btn btn-primary">
              Create account
            </button>
          </form>

          <div className="auth-footer">
            <p>
              Already have an account? <Link to="/login">Sign in</Link>
            </p>
          </div>
        </section>
      </main>
    </>
  );
}
