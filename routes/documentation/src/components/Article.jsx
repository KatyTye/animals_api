export default function Article() {

	return (
		<article className="page-article">
			<h2 className="page-article__title">
				ABOUT THIS API
			</h2>

			<p className="page-article__important">
				<span>
					IMPORTANT:
				</span> All other methods then
				<span className="GET"> GET </span>
				requires admin authorization.
			</p>

			<a href="https://github.com/KatyTye/animals_api" target="_blank">
				Click here to open GitHub Repo
			</a>

			<p className="page-article__text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nostrum fuga quod repellendus ab animi molestiae mollitia non eligendi ex, maiores quo possimus ipsum.</p>

			<p className="page-article__text">Dolor sit amet consectetur adipisicing elit. Quas suscipit eveniet tenetur, hic iusto rerum nisi. Eos in sint esse, suscipit voluptatibus odit veritatis corrupti ipsum officiis id sit culpa eum possimus nisi earum eaque aliquid sunt molestias et fuga ea! Et qui natus architecto. Libero cumque corrupti sed. Quisquam.</p>
		</article>
	)
}