import ClipLoader from "react-spinners/ClipLoader";

const Loader = ({ color, loading, size }) => {
    return (
        <ClipLoader
            color={color}
            loading={loading}
            size={size}
            aria-label="Loading Spinner"
            data-testid="loader"
        />
    );
};

export default Loader;
