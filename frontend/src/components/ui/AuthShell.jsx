export default function AuthShell({ title, subtitle, children, footer }) {
  return (
    <main className="auth-screen">
      <section className="auth-card" aria-label={title}>
        <div className="auth-card__header">
          <p className="auth-badge">EduFlow</p>
          <h1>{title}</h1>
          <p>{subtitle}</p>
        </div>

        <div className="auth-card__body">{children}</div>

        {footer ? <div className="auth-card__footer">{footer}</div> : null}
      </section>
    </main>
  )
}