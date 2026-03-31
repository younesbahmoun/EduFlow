export default function RoleCard({ label, description, value, selected, onSelect }) {
  return (
    <button
      type="button"
      className={`role-card ${selected ? 'role-card--active' : ''}`}
      onClick={() => onSelect(value)}
      aria-pressed={selected}
    >
      <span className="role-card__title">{label}</span>
      <span className="role-card__text">{description}</span>
    </button>
  )
}