export default function Button({ children, type = 'button' }) {
  return (
    <button type={type} className="btn btn--primary">
      {children}
    </button>
  )
}