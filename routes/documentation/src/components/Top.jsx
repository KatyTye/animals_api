export default function Top() {

	return (
		<button className="overlay-content" id="top-button"
			onClick={() => { location.hash = "#top" }}>
			TOP
		</button>
	)
}