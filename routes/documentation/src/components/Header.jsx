export default function Header() {

	return (
		<header className="top-content">
			<figure className="top-content__holder">
				<img src="fox.svg" alt="page logo of a fox"
					className="top-content__image" loading="lazy" />
				<figcaption className="top-content__title">
					Animals API
				</figcaption>
			</figure>
			<p className="top-content__other">documentation</p>
		</header>
	)
}