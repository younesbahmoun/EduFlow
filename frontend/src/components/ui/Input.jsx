export default function Input({
  label,
  id,
  type = 'text',
  placeholder,
  value,
  onChange,
  autoComplete,
}) {
  return (
    <div className="field">
      <label htmlFor={id} className="field__label">
        {label}
      </label>

      <input
        id={id}
        type={type}
        className="field__input"
        placeholder={placeholder}
        value={value}
        onChange={onChange}
        autoComplete={autoComplete}
      />
    </div>
  )
}