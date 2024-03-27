const ReviewCard = ({ review }) => {
    const stars = [];

    for (let i = 0; i < 5; i++) {
        stars.push(
            i < review.rating ? (
                <i className="fa-solid fa-star" key={i}></i>
            ) : (
                <i className="fa-regular fa-star" key={i}></i>
            )
        );
    }
    return (
        <div className="w-full flex-col flex gap-4 p-4 dark:bg-gray-600 bg-white shadow-md rounded-md">
            <div className="flex justify-between">
                <span className="font-semibold">{review.user.name}</span>
                <span>{review.time_ago}</span>
            </div>
            <p>{review.feedback}</p>
            <div>
                {stars} {review.rating}
            </div>
        </div>
    );
};

export default ReviewCard;
